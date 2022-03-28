<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    const ADMIN = 'admin';
    const LECTURER = 'lecturer';
    const STUDENT = 'student';
    const HR = 'hr';

    protected $guarded = [];

    public function users() : HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
