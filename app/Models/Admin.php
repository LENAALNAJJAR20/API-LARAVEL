<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $table = 'admins';
    protected $fillable = ['name', 'email', 'password','created_at','updated_at'];
    public function getJWTIdentifier()
    {
        // Return the primary key of the user
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // Return any custom claims you want to add to the JWT
        return [];
    }
}
