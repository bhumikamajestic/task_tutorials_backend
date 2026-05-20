<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homeworks';

    protected $fillable = [
        'class_id',
        'student_id',
        'topic',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Homework belongs to class
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Homework belongs to student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}