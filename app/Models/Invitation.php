<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Invitation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'token',
        'expires_at',
        'used_at',
        'created_by',
        'role',
        'invitation_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'invitation_type' => 'string',
    ];

    /**
     * Get the user who created this invitation.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the role that will be assigned when this invitation is used.
     */
    public function assignedRole(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role', 'name');
    }

    /**
     * Scope a query to only include active invitations.
     */
    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', now())
            ->whereNull('used_at');
    }

    /**
     * Scope a query to only include expired invitations.
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    /**
     * Scope a query to only include used invitations.
     */
    public function scopeUsed($query)
    {
        return $query->whereNotNull('used_at');
    }

    /**
     * Scope a query to only include unused invitations.
     */
    public function scopeUnused($query)
    {
        return $query->whereNull('used_at');
    }

    /**
     * Scope a query to filter by invitation type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('invitation_type', $type);
    }

    /**
     * Check if the invitation is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if the invitation has been used.
     */
    public function isUsed(): bool
    {
        return !is_null($this->used_at);
    }

    /**
     * Check if the invitation is valid (not expired and not used).
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->isUsed();
    }

    /**
     * Mark the invitation as used.
     */
    public function markAsUsed(): void
    {
        $this->update(['used_at' => now()]);
    }

    /**
     * Generate a secure invitation token.
     */
    public static function generateToken(): string
    {
        $length = config('registration.invitation_token_length', 32);
        return Str::random($length);
    }

    /**
     * Create a new invitation with a generated token and expiry date.
     */
    public static function createInvitation(array $data): self
    {
        $expiryHours = config('registration.invitation_expiry_hours', 72);

        return self::create([
            'email' => $data['email'],
            'token' => self::generateToken(),
            'expires_at' => now()->addHours($expiryHours),
            'created_by' => $data['created_by'],
            'role' => $data['role'] ?? null,
            'invitation_type' => $data['invitation_type'] ?? 'user',
        ]);
    }

    /**
     * Find an invitation by token and email.
     */
    public static function findByToken(string $token, string $email): ?self
    {
        return self::where('token', $token)
            ->where('email', $email)
            ->first();
    }

    /**
     * Find a valid invitation by token and email.
     */
    public static function findValidByToken(string $token, string $email): ?self
    {
        return self::where('token', $token)
            ->where('email', $email)
            ->active()
            ->first();
    }
}
