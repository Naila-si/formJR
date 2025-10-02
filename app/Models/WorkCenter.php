<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkCenter extends Model
{
    protected $fillable = ['name','slug','color'];

    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
