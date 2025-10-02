<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name','handle','avatar_url'];

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}
