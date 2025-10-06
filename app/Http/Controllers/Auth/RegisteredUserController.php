<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        // Check if there's an invitation token in the URL
        $invitation = null;
        if ($request->has('token') && $request->has('email')) {
            $invitation = Invitation::findValidByToken($request->token, $request->email);
        }

        return view('auth.register', compact('invitation'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Build validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        // Add invitation token validation if provided
        if ($request->filled('invitation_token')) {
            $rules['invitation_token'] = ['required', 'string'];
            $rules['invitation_email'] = ['required', 'email'];
        }

        $request->validate($rules);

        // Check for invitation if token is provided
        $invitation = null;
        if ($request->filled('invitation_token')) {
            $invitation = Invitation::findValidByToken(
                $request->invitation_token,
                $request->invitation_email
            );

            if (!$invitation) {
                return back()->withErrors([
                    'invitation_token' => 'Invalid or expired invitation token.'
                ])->withInput();
            }

            // Ensure the email matches the invitation
            if ($invitation->email !== $request->email) {
                return back()->withErrors([
                    'email' => 'Email does not match the invitation.'
                ])->withInput();
            }

            // For invitations, use the invitation email if the form email is empty/readonly
            if (empty($request->email) || $request->email !== $invitation->email) {
                $request->merge(['email' => $invitation->email]);
            }
        }

        // Check if self-registration is allowed (when no invitation)
        if (!$invitation && !config('registration.allow_self_registration', true)) {
            return back()->withErrors([
                'email' => 'Self-registration is not allowed. Please use an invitation link.'
            ])->withInput();
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role based on invitation or default
        if ($invitation && $invitation->role) {
            $user->assignRole($invitation->role);
        } elseif (!$invitation) {
            // Assign default role for self-registration
            $defaultRole = config('registration.default_role_for_self_registration', 'user');
            $user->assignRole($defaultRole);
        }

        // Mark invitation as used if applicable
        if ($invitation) {
            $invitation->markAsUsed();
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
