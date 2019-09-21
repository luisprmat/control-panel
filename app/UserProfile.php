<?php

namespace App;

use App\Profession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function profession()
    {
        return $this->belongsTo(Profession::class)->withDefault([
            'title' => '(No registra profesión)'
        ]);
    }
}
