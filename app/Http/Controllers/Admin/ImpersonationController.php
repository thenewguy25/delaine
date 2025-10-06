<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ImpersonationController extends Controller
{
    /**
     * Start impersonating a user
     */
    public function start(Request $request, User $user)
    {
        // Prevent impersonating inactive users
        if (!$user->is_active) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot impersonate inactive users.');
        }

        // Prevent self-impersonation
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot impersonate yourself.');
        }

        // Store original user ID in session
        Session::put('impersonator_id', Auth::id());

        // Log in as the target user
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', "You are now impersonating {$user->name}. Use the 'Stop Impersonating' button to return to your account.");
    }

    /**
     * Stop impersonating and return to original user
     */
    public function stop()
    {
        $impersonatorId = Session::get('impersonator_id');

        if (!$impersonatorId) {
            return redirect()->route('dashboard')
                ->with('error', 'No active impersonation session found.');
        }

        // Get the original admin user
        $impersonator = User::find($impersonatorId);

        if (!$impersonator) {
            return redirect()->route('dashboard')
                ->with('error', 'Original user not found.');
        }

        // Clear impersonation session
        Session::forget('impersonator_id');

        // Log back in as the original user
        Auth::login($impersonator);

        return redirect()->route('admin.users.index')
            ->with('success', 'You have stopped impersonating and returned to your admin account.');
    }

    /**
     * Check if currently impersonating
     */
    public static function isImpersonating(): bool
    {
        return Session::has('impersonator_id');
    }

    /**
     * Get the impersonator user
     */
    public static function getImpersonator(): ?User
    {
        $impersonatorId = Session::get('impersonator_id');
        return $impersonatorId ? User::find($impersonatorId) : null;
    }
}
