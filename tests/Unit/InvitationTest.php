<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Invitation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_invitation()
    {
        $user = User::factory()->create();

        $invitation = Invitation::create([
            'email' => 'test@example.com',
            'token' => 'test-token-123',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(Invitation::class, $invitation);
        $this->assertEquals('test@example.com', $invitation->email);
        $this->assertEquals('test-token-123', $invitation->token);
        $this->assertEquals('user', $invitation->invitation_type);
        $this->assertEquals('user', $invitation->role);
        $this->assertEquals($user->id, $invitation->created_by);
    }

    /** @test */
    public function it_can_generate_a_unique_token()
    {
        $user = User::factory()->create();

        $invitation1 = Invitation::create([
            'email' => 'test1@example.com',
            'token' => Invitation::generateToken(),
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        $invitation2 = Invitation::create([
            'email' => 'test2@example.com',
            'token' => Invitation::generateToken(),
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        $this->assertNotEquals($invitation1->token, $invitation2->token);
        $this->assertIsString($invitation1->token);
        $this->assertIsString($invitation2->token);
    }

    /** @test */
    public function it_can_check_if_invitation_is_expired()
    {
        $user = User::factory()->create();

        $activeInvitation = Invitation::create([
            'email' => 'active@example.com',
            'token' => 'active-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(24),
            'created_by' => $user->id,
        ]);

        $expiredInvitation = Invitation::create([
            'email' => 'expired@example.com',
            'token' => 'expired-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->subHours(1),
            'created_by' => $user->id,
        ]);

        $this->assertFalse($activeInvitation->isExpired());
        $this->assertTrue($expiredInvitation->isExpired());
    }

    /** @test */
    public function it_can_check_if_invitation_is_used()
    {
        $user = User::factory()->create();

        $unusedInvitation = Invitation::create([
            'email' => 'unused@example.com',
            'token' => 'unused-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        $usedInvitation = Invitation::create([
            'email' => 'used@example.com',
            'token' => 'used-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
            'used_at' => now(),
        ]);

        $this->assertFalse($unusedInvitation->isUsed());
        $this->assertTrue($usedInvitation->isUsed());
    }

    /** @test */
    public function it_can_check_if_invitation_is_valid()
    {
        $user = User::factory()->create();

        $validInvitation = Invitation::create([
            'email' => 'valid@example.com',
            'token' => 'valid-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        $expiredInvitation = Invitation::create([
            'email' => 'expired@example.com',
            'token' => 'expired-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->subHours(1),
            'created_by' => $user->id,
        ]);

        $usedInvitation = Invitation::create([
            'email' => 'used@example.com',
            'token' => 'used-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
            'used_at' => now(),
        ]);

        $this->assertTrue($validInvitation->isValid());
        $this->assertFalse($expiredInvitation->isValid());
        $this->assertFalse($usedInvitation->isValid());
    }

    /** @test */
    public function it_can_mark_invitation_as_used()
    {
        $user = User::factory()->create();

        $invitation = Invitation::create([
            'email' => 'test@example.com',
            'token' => 'test-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        $this->assertFalse($invitation->isUsed());
        $this->assertNull($invitation->used_at);

        $invitation->markAsUsed();

        $this->assertTrue($invitation->fresh()->isUsed());
        $this->assertNotNull($invitation->fresh()->used_at);
    }

    /** @test */
    public function it_can_extend_invitation_expiry()
    {
        $user = User::factory()->create();

        $invitation = Invitation::create([
            'email' => 'test@example.com',
            'token' => 'test-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(24),
            'created_by' => $user->id,
        ]);

        $originalExpiry = $invitation->expires_at;

        $invitation->extendExpiry(48); // Extend by 48 hours

        $this->assertTrue($invitation->fresh()->expires_at->gt($originalExpiry));
        // Just verify that the expiry was updated and is in the future
        $this->assertTrue($invitation->fresh()->expires_at->isFuture());
    }

    /** @test */
    public function it_belongs_to_creator()
    {
        $user = User::factory()->create();

        $invitation = Invitation::create([
            'email' => 'test@example.com',
            'token' => 'test-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $invitation->creator);
        $this->assertEquals($user->id, $invitation->creator->id);
    }

    /** @test */
    public function it_can_find_invitation_by_token()
    {
        $user = User::factory()->create();

        $invitation = Invitation::create([
            'email' => 'test@example.com',
            'token' => 'unique-token-123',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        $foundInvitation = Invitation::findByToken('unique-token-123');

        $this->assertInstanceOf(Invitation::class, $foundInvitation);
        $this->assertEquals($invitation->id, $foundInvitation->id);
    }

    /** @test */
    public function it_returns_null_when_token_not_found()
    {
        $foundInvitation = Invitation::findByToken('non-existent-token');

        $this->assertNull($foundInvitation);
    }

    /** @test */
    public function it_can_scope_active_invitations()
    {
        $user = User::factory()->create();

        Invitation::create([
            'email' => 'active@example.com',
            'token' => 'active-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        Invitation::create([
            'email' => 'expired@example.com',
            'token' => 'expired-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->subHours(1),
            'created_by' => $user->id,
        ]);

        Invitation::create([
            'email' => 'used@example.com',
            'token' => 'used-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
            'used_at' => now(),
        ]);

        $activeInvitations = Invitation::active()->get();

        $this->assertCount(1, $activeInvitations);
        $this->assertEquals('active@example.com', $activeInvitations->first()->email);
    }

    /** @test */
    public function it_can_scope_expired_invitations()
    {
        $user = User::factory()->create();

        Invitation::create([
            'email' => 'active@example.com',
            'token' => 'active-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        Invitation::create([
            'email' => 'expired@example.com',
            'token' => 'expired-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->subHours(1),
            'created_by' => $user->id,
        ]);

        $expiredInvitations = Invitation::expired()->get();

        $this->assertCount(1, $expiredInvitations);
        $this->assertEquals('expired@example.com', $expiredInvitations->first()->email);
    }

    /** @test */
    public function it_can_scope_used_invitations()
    {
        $user = User::factory()->create();

        Invitation::create([
            'email' => 'unused@example.com',
            'token' => 'unused-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        Invitation::create([
            'email' => 'used@example.com',
            'token' => 'used-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
            'used_at' => now(),
        ]);

        $usedInvitations = Invitation::used()->get();

        $this->assertCount(1, $usedInvitations);
        $this->assertEquals('used@example.com', $usedInvitations->first()->email);
    }

    /** @test */
    public function it_casts_expires_at_to_datetime()
    {
        $user = User::factory()->create();

        $invitation = Invitation::create([
            'email' => 'test@example.com',
            'token' => 'test-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(Carbon::class, $invitation->expires_at);
    }

    /** @test */
    public function it_casts_used_at_to_datetime()
    {
        $user = User::factory()->create();

        $invitation = Invitation::create([
            'email' => 'test@example.com',
            'token' => 'test-token',
            'invitation_type' => 'user',
            'role' => 'user',
            'expires_at' => now()->addHours(72),
            'created_by' => $user->id,
            'used_at' => now(),
        ]);

        $this->assertInstanceOf(Carbon::class, $invitation->used_at);
    }
}
