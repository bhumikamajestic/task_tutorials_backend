<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'enrollments';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'userId',

        'classId',

        'dob',

        'address',

        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Enrollment belongs to user
    public function user()
    {
        return $this->belongsTo(

            User::class,

            'userId'
        );
    }

    // Enrollment belongs to class
    public function class()
    {
        return $this->belongsTo(

            ClassModel::class,

            'classId'
        );
    }
}