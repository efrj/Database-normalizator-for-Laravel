<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Table that owns the Field.
     */
    public function table()
    {
        return $this->belongsTo('App\Models\Table');
    }
}
