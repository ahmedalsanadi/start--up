<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

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

    public function isAdmin()
    {

        return $this->user_type == 1;
    }

    public function isInvestor()
    {

        return $this->user_type == 2;
    }

    public function isEntrepreneur()
    {
        return $this->user_type == 3;
    }

    // app/Models/User.php
    public function commercialRegistration()
    {
        return $this->hasOne(CommercialRegistration::class);
    }

    public function hasApprovedRegistration()
    {
        return $this->commercialRegistration && $this->commercialRegistration->status === 'approved';
    }

}
