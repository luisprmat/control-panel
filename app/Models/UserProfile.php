<?php

namespace App\Models;

use App\Models\Profession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function profession()
    {
        return $this->belongsTo(Profession::class)->withDefault([
            'title' => '(No registra profesión)'
        ]);
    }
}
