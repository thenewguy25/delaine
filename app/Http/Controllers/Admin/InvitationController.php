<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use Illuminate\Validation\Rule;

class InvitationController extends Controller
{
    /**
     * Display a listing of invitations.
     */
    public function index(Request $request): View
    {
        $query = Invitation::with(['creator', 'assignedRole']);

        // Apply filters
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->active();
                    break;
                case 'expired':
                    $query->expired();
                    break;
                case 'used':
                    $query->used();
                    break;
                case 'unused':
                    $query->unused();
                    break;
            }
        }

        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $invitations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.invitations.index', compact('invitations'));
    }

    /**
     * Show the form for creating a new invitation.
     */
    public function create(): View
    {
        $roles = Role::all();
        return view('admin.invitations.create', compact('roles'));
    }

    /**
     * Store a newly created invitation.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('invitations', 'email')->where(function ($query) {
                    return $query->whereNull('used_at');
                }),
                Rule::unique('users', 'email'),
            ],
            'role' => ['nullable', 'string', 'exists:roles,name'],
            'invitation_type' => ['required', 'in:admin,user,custom'],
        ], [
            'email.unique' => 'An active invitation or user already exists with this email address.',
        ]);

        // Check if user already exists
        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors([
                'email' => 'A user with this email already exists.'
            ])->withInput();
        }

        // Create the invitation
        $invitation = Invitation::createInvitation([
            'email' => $request->email,
            'created_by' => auth()->id(),
            'role' => $request->role,
            'invitation_type' => $request->invitation_type,
        ]);

        // Send invitation email
        try {
            Mail::to($request->email)->send(new InvitationMail($invitation));

            return redirect()->route('admin.invitations.index')
                ->with('success', "Invitation sent successfully to {$request->email}");
        } catch (\Exception $e) {
            // If email fails, still create the invitation but show warning
            return redirect()->route('admin.invitations.index')
                ->with('warning', "Invitation created but email failed to send. Token: {$invitation->token}");
        }
    }

    /**
     * Display the specified invitation.
     */
    public function show(Invitation $invitation): View
    {
        $invitation->load(['creator', 'assignedRole']);
        return view('admin.invitations.show', compact('invitation'));
    }

    /**
     * Show the form for editing the specified invitation.
     */
    public function edit(Invitation $invitation): View
    {
        $roles = Role::all();
        return view('admin.invitations.edit', compact('invitation', 'roles'));
    }

    /**
     * Update the specified invitation.
     */
    public function update(Request $request, Invitation $invitation): RedirectResponse
    {
        // Only allow editing unused invitations
        if ($invitation->isUsed()) {
            return back()->withErrors([
                'invitation' => 'Cannot edit a used invitation.'
            ]);
        }

        $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('invitations', 'email')->ignore($invitation->id)->where(function ($query) {
                    return $query->whereNull('used_at');
                }),
                Rule::unique('users', 'email'),
            ],
            'role' => ['nullable', 'string', 'exists:roles,name'],
            'invitation_type' => ['required', 'in:admin,user,custom'],
            'expires_at' => ['required', 'date', 'after:now'],
        ], [
            'email.unique' => 'An active invitation or user already exists with this email address.',
        ]);

        $invitation->update([
            'email' => $request->email,
            'role' => $request->role,
            'invitation_type' => $request->invitation_type,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.invitations.index')
            ->with('success', 'Invitation updated successfully.');
    }

    /**
     * Remove the specified invitation.
     */
    public function destroy(Invitation $invitation): RedirectResponse|JsonResponse
    {
        $email = $invitation->email;
        $invitation->delete();

        // Handle AJAX requests
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Invitation for {$email} has been cancelled."
            ]);
        }

        return redirect()->route('admin.invitations.index')
            ->with('success', "Invitation for {$email} has been cancelled.");
    }

    /**
     * Resend an invitation email.
     */
    public function resend(Invitation $invitation): RedirectResponse|JsonResponse
    {
        if ($invitation->isUsed()) {
            $error = 'Cannot resend a used invitation.';
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $error], 400);
            }
            return back()->withErrors(['invitation' => $error]);
        }

        if ($invitation->isExpired()) {
            $error = 'Cannot resend an expired invitation.';
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $error], 400);
            }
            return back()->withErrors(['invitation' => $error]);
        }

        try {
            Mail::to($invitation->email)->send(new InvitationMail($invitation));

            $message = 'Invitation email resent successfully.';
            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => $message]);
            }
            return back()->with('success', $message);
        } catch (\Exception $e) {
            $error = 'Failed to send invitation email. Please try again.';
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $error], 500);
            }
            return back()->withErrors(['email' => $error]);
        }
    }

    /**
     * Extend the expiry date of an invitation.
     */
    public function extend(Invitation $invitation): RedirectResponse|JsonResponse
    {
        if ($invitation->isUsed()) {
            $error = 'Cannot extend a used invitation.';
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $error], 400);
            }
            return back()->withErrors(['invitation' => $error]);
        }

        $expiryHours = config('registration.invitation_expiry_hours', 72);
        $invitation->update([
            'expires_at' => now()->addHours($expiryHours)
        ]);

        $message = 'Invitation expiry date extended successfully.';
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return back()->with('success', $message);
    }

    /**
     * Bulk actions on invitations.
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete,extend'],
            'invitations' => ['required', 'array', 'min:1'],
            'invitations.*' => ['exists:invitations,id'],
        ]);

        $invitations = Invitation::whereIn('id', $request->invitations);
        $count = $invitations->count();

        switch ($request->action) {
            case 'delete':
                $invitations->delete();
                $message = "{$count} invitation(s) deleted successfully.";
                break;
            case 'extend':
                $expiryHours = config('registration.invitation_expiry_hours', 72);
                $invitations->update(['expires_at' => now()->addHours($expiryHours)]);
                $message = "{$count} invitation(s) extended successfully.";
                break;
        }

        return redirect()->route('admin.invitations.index')
            ->with('success', $message);
    }
}
