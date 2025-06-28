<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\AuthStatus;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'status',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => AuthStatus::class,
        ];
    }

    protected $appends = ['status_label', 'name'];

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    
    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }
}
