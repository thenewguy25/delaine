<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Registration Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for the hybrid registration
    | system. Users can register themselves or be invited by admins.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Self Registration
    |--------------------------------------------------------------------------
    |
    | Allow users to register themselves without an invitation.
    | When enabled, users can create accounts directly from the registration form.
    |
    */
    'allow_self_registration' => env('ALLOW_SELF_REGISTRATION', true),

    /*
    |--------------------------------------------------------------------------
    | Auto Assign Role on Invite
    |--------------------------------------------------------------------------
    |
    | When an admin sends an invitation, automatically assign the specified
    | role to the user when they complete registration.
    |
    */
    'auto_assign_role_on_invite' => env('AUTO_ASSIGN_ROLE_ON_INVITE', true),

    /*
    |--------------------------------------------------------------------------
    | Default Role for Self Registration
    |--------------------------------------------------------------------------
    |
    | The default role assigned to users who register themselves.
    | This should be a role that exists in your roles table.
    |
    */
    'default_role_for_self_registration' => env('DEFAULT_ROLE_SELF_REGISTRATION', 'user'),

    /*
    |--------------------------------------------------------------------------
    | Invitation Expiry
    |--------------------------------------------------------------------------
    |
    | Number of hours after which an invitation expires.
    | Expired invitations cannot be used for registration.
    |
    */
    'invitation_expiry_hours' => env('INVITATION_EXPIRY_HOURS', 72),

    /*
    |--------------------------------------------------------------------------
    | Invitation Token Length
    |--------------------------------------------------------------------------
    |
    | Length of the random token generated for invitations.
    | Longer tokens are more secure but take more space.
    |
    */
    'invitation_token_length' => env('INVITATION_TOKEN_LENGTH', 32),

    /*
    |--------------------------------------------------------------------------
    | Invitation Email Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for invitation emails.
    |
    */
    'email' => [
        'subject' => env('INVITATION_EMAIL_SUBJECT', 'You\'re invited to join :app_name'),
        'from_name' => env('INVITATION_EMAIL_FROM_NAME', config('app.name')),
        'from_email' => env('INVITATION_EMAIL_FROM_EMAIL', config('mail.from.address')),
    ],
];
