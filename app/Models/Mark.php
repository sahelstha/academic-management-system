<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'marks',
        'grade',
    ];

    // ═══════════════════════════════
    //         RELATIONSHIPS
    // ═══════════════════════════════

    // A mark belongs to one student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // A mark belongs to one course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // ═══════════════════════════════
    //      GRADE LOGIC (STATIC)
    // ═══════════════════════════════

    // Automatically calculate grade from marks
    public static function assignGrade(float $marks): string
    {
        return match(true) {
            $marks >= 90 => 'A+',
            $marks >= 80 => 'A',
            $marks >= 70 => 'B',
            $marks >= 60 => 'C',
            $marks >= 50 => 'D',
            default      => 'F',
        };
    }

    // Check if this mark is a pass
    public function isPassed(): bool
    {
        return $this->marks >= 50;
    }
}