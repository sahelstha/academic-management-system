<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'code',
        'credit_hours',
        'teacher_id',
    ];

    // ═══════════════════════════════
    //         RELATIONSHIPS
    // ═══════════════════════════════

    // A course belongs to one teacher (who is a user)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // A course has many students (through enrollments)
    public function students()
    {
        return $this->belongsToMany(
            Student::class,      // related model
            'enrollments',       // pivot table
            'course_id',         // foreign key for course
            'student_id'         // foreign key for student
        );
    }

    // A course has many marks
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    // ═══════════════════════════════
    //         HELPER METHODS
    // ═══════════════════════════════

    // Get average marks for this course
    public function averageMarks(): float
    {
        return $this->marks()->avg('marks') ?? 0;
    }

    // Count total enrolled students
    public function totalStudents(): int
    {
        return $this->students()->count();
    }
}