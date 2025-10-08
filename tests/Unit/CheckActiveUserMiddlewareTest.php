<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Http\Middleware\CheckActiveUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckActiveUserMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new CheckActiveUser();
    }

    /** @test */
    public function it_allows_active_users_to_pass()
    {
        $user = User::factory()->create(['is_active' => true]);
        Auth::login($user);

        $request = Request::create('/test', 'GET');
        $request->setLaravelSession($this->app['session.store']);

        $response = $this->middleware->handle($request, function ($req) {
            return new Response('OK');
        });

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getContent());
    }

    /** @test */
    public function it_blocks_inactive_users()
    {
        $user = User::factory()->create(['is_active' => false]);
        Auth::login($user);

        $request = Request::create('/test', 'GET');
        $request->setLaravelSession($this->app['session.store']);

        $response = $this->middleware->handle($request, function ($req) {
            return new Response('OK');
        });

        $this->assertTrue($response->isRedirect());
        $this->assertEquals(route('login'), $response->headers->get('Location'));
    }

    /** @test */
    public function it_logs_out_inactive_users()
    {
        $user = User::factory()->create(['is_active' => false]);
        Auth::login($user);

        $this->assertTrue(Auth::check());

        $request = Request::create('/test', 'GET');
        $request->setLaravelSession($this->app['session.store']);

        $this->middleware->handle($request, function ($req) {
            return new Response('OK');
        });

        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function it_allows_unauthenticated_users_to_pass()
    {
        $this->assertFalse(Auth::check());

        $request = Request::create('/test', 'GET');
        $request->setLaravelSession($this->app['session.store']);

        $response = $this->middleware->handle($request, function ($req) {
            return new Response('OK');
        });

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getContent());
    }

    /** @test */
    public function it_handles_multiple_requests_correctly()
    {
        $activeUser = User::factory()->create(['is_active' => true]);
        $inactiveUser = User::factory()->create(['is_active' => false]);

        // Test active user
        Auth::login($activeUser);
        $request = Request::create('/test1', 'GET');
        $request->setLaravelSession($this->app['session.store']);
        $response = $this->middleware->handle($request, function ($req) {
            return new Response('OK');
        });
        $this->assertEquals(200, $response->getStatusCode());

        // Test inactive user
        Auth::login($inactiveUser);
        $request = Request::create('/test2', 'GET');
        $request->setLaravelSession($this->app['session.store']);
        $response = $this->middleware->handle($request, function ($req) {
            return new Response('OK');
        });
        $this->assertTrue($response->isRedirect());
    }

    /** @test */
    public function it_handles_post_requests()
    {
        $user = User::factory()->create(['is_active' => false]);
        Auth::login($user);

        $request = Request::create('/test', 'POST');
        $request->setLaravelSession($this->app['session.store']);
        $response = $this->middleware->handle($request, function ($req) {
            return new Response('OK');
        });

        $this->assertTrue($response->isRedirect());
        $this->assertEquals(route('login'), $response->headers->get('Location'));
    }

    /** @test */
    public function it_handles_ajax_requests()
    {
        $user = User::factory()->create(['is_active' => false]);
        Auth::login($user);

        $request = Request::create('/test', 'GET');
        $request->headers->set('X-Requested-With', 'XMLHttpRequest');
        $request->setLaravelSession($this->app['session.store']);

        $response = $this->middleware->handle($request, function ($req) {
            return new Response('OK');
        });

        $this->assertTrue($response->isRedirect());
    }
}