<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    // Guarded is the reverse of fillable. If fillable specifies which fields to be mass assigned, guarded specifies which fields are not mass assignable.
    protected $guarded=[];
    protected $hidden =['password'];


}
