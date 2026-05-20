<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'roleId',
        'name',
        'email',
        'password',
        'phone_no'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // User belongs to mas role
    public function masRole()
    {
        return $this->belongsTo(MasRole::class, 'roleId');
    }

    // User has one student
    public function student()
    {
        return $this->hasOne(Student::class, 'userId');
    }

    // User has one faculty
    public function faculty()
    {
        return $this->hasOne(Faculty::class, 'user_id');
    }
}
