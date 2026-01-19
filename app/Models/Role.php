<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMIN = 1;

    const DOCTOR = 2;

    const PATIENT = 3;

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
