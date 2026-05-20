<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'name'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Subject belongs to one faculty
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    // Subject has many classes
    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'subjectId');
    }

    // Subject has many notes
    public function notes()
    {
        return $this->hasMany(Note::class, 'subject_id');
    }
}
