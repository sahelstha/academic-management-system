<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Columns that can be mass-assigned (filled via forms)
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    // Columns to hide (never expose these in JSON responses)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ═══════════════════════════════
    //         RELATIONSHIPS
    // ═══════════════════════════════

    // A user belongs to one role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // A user (student) has one student profile
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // A user (teacher) has many courses
    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    // ═══════════════════════════════
    //         HELPER METHODS
    // ═══════════════════════════════

    // Check if user is admin
    public function isAdmin(): bool
    {
        return $this->role->name === 'admin';
    }

    // Check if user is teacher
    public function isTeacher(): bool
    {
        return $this->role->name === 'teacher';
    }

    // Check if user is student
    public function isStudent(): bool
    {
        return $this->role->name === 'student';
    }
}