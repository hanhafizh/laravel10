<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    // relasi many to many
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_assets');
    }
}
