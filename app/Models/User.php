<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Profile image URL (Gravatar, with branded initials fallback).
     */
    public function avatarUrl(int $size = 96): string
    {
        $hash = md5(strtolower(trim($this->email)));
        $fallback = urlencode(
            'https://ui-avatars.com/api/?name='.urlencode($this->name)
            .'&background=9C3620&color=ffffff&size='.$size.'&bold=true'
        );

        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d={$fallback}";
    }
}
