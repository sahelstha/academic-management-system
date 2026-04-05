<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'enrollment_year',
    ];

    // ═══════════════════════════════
    //         RELATIONSHIPS
    // ═══════════════════════════════

    // A student belongs to one user (for name, email, password)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A student belongs to many courses (through enrollments)
    public function courses()
    {
        return $this->belongsToMany(
            Course::class,       // related model
            'enrollments',       // pivot/bridge table
            'student_id',        // foreign key on enrollments for student
            'course_id'          // foreign key on enrollments for course
        );
    }

    // A student has many marks
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    // ═══════════════════════════════
    //         HELPER METHODS
    // ═══════════════════════════════

    // Get student's full name via user relationship
    public function getNameAttribute(): string
    {
        return $this->user->name;
    }

    // Get student's email via user relationship
    public function getEmailAttribute(): string
    {
        return $this->user->email;
    }

    // Calculate average marks for this student
    public function averageMarks(): float
    {
        return $this->marks()->avg('marks') ?? 0;
    }
}