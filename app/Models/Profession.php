<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profession extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function profiles()
    {
        return $this->hasMany(UserProfile::class);
    }
}
