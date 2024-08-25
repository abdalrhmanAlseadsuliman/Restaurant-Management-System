<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // وراثة من Authenticatable
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends  Authenticatable implements JWTSubject
{

    use HasFactory;

    protected $table = 'admins';
    protected $fillable = [
        'name','email','password'
    ];

    // JWT implementation
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // باقي الأكواد...
}
