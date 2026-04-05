<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    // ═══════════════════════════════
    //         RELATIONSHIPS
    // ═══════════════════════════════

    // A role belongs to many users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}