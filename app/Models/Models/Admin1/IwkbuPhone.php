<?php

namespace App\Models\Models\Admin1;

use App\Models\Admin1\Iwkbu;
use Illuminate\Database\Eloquent\Model;

class IwkbuPhone extends Model
{
    protected $fillable = ['iwkbu_id', 'no_hp'];

    public function iwkbu()
    {
        return $this->belongsTo(Iwkbu::class);
    }
}
