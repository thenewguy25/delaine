<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Roles Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the default roles and permissions for the Delaine
    | framework. Developers can modify this file or use the artisan commands
    | to add custom roles and permissions.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Roles
    |--------------------------------------------------------------------------
    |
    | Define the default roles that will be created when running the
    | role seeder. Each role can have permissions assigned to it.
    |
    */
    'default_roles' => [
        'admin' => [
            'permissions' => ['manage users', 'manage roles', 'manage permissions', 'manage settings', 'access dashboard', 'manage profile'],
            'description' => 'Full system access with all permissions',
        ],
        'moderator' => [
            'permissions' => ['moderate content', 'manage comments', 'access dashboard', 'manage profile'],
            'description' => 'Content moderation and comment management',
        ],
        'editor' => [
            'permissions' => ['create posts', 'edit posts', 'delete posts', 'access dashboard', 'manage profile'],
            'description' => 'Content creation and editing capabilities',
        ],
        'analyst' => [
            'permissions' => ['view analytics', 'access dashboard', 'manage profile'],
            'description' => 'Analytics and reporting access',
        ],
        'user' => [
            'permissions' => ['access dashboard', 'manage profile'],
            'description' => 'Basic user access with dashboard and profile management',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Available Permissions
    |--------------------------------------------------------------------------
    |
    | List of all available permissions in the system. These will be created
    | when running the role seeder.
    |
    */
    'available_permissions' => [
        'manage users',
        'manage roles',
        'manage permissions',
        'moderate content',
        'manage comments',
        'create posts',
        'edit posts',
        'delete posts',
        'view analytics',
        'manage settings',
        'access dashboard',
        'manage profile',
    ],

    /*
    |--------------------------------------------------------------------------
    | Role Hierarchy
    |--------------------------------------------------------------------------
    |
    | Define the role hierarchy. Higher roles inherit permissions from
    | lower roles. This is useful for permission checking.
    |
    */
    'hierarchy' => [
        'admin' => ['moderator', 'editor', 'analyst', 'user'],
        'moderator' => ['user'],
        'editor' => ['user'],
        'analyst' => ['user'],
        'user' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Role for Self Registration
    |--------------------------------------------------------------------------
    |
    | The role that will be assigned to users who register themselves
    | without an invitation.
    |
    */
    'default_self_registration_role' => 'user',

    /*
    |--------------------------------------------------------------------------
    | Role Display Names
    |--------------------------------------------------------------------------
    |
    | Human-readable display names for roles. Used in the admin interface
    | and other user-facing areas.
    |
    */
    'display_names' => [
        'admin' => 'Administrator',
        'moderator' => 'Moderator',
        'editor' => 'Editor',
        'analyst' => 'Analyst',
        'user' => 'User',
    ],

    /*
    |--------------------------------------------------------------------------
    | Role Colors
    |--------------------------------------------------------------------------
    |
    | CSS classes for role badges in the admin interface.
    |
    */
    'badge_colors' => [
        'admin' => 'bg-red-100 text-red-800',
        'moderator' => 'bg-orange-100 text-orange-800',
        'editor' => 'bg-blue-100 text-blue-800',
        'analyst' => 'bg-purple-100 text-purple-800',
        'user' => 'bg-gray-100 text-gray-800',
    ],
];
