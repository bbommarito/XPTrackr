<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MagicLink extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'used',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($magicLink) {
            if (empty($magicLink->token)) {
                $magicLink->token = (string) Str::uuid();
            }

            if (empty($magicLink->expires_at)) {
                $magicLink->expires_at = now()->addMinutes(15);
            }
        });
    }

    /**
     * Get the user that owns the magic link.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the magic link is valid (not expired and not used).
     */
    public function isValid(): bool
    {
        return ! $this->used && $this->expires_at->isFuture();
    }
}
