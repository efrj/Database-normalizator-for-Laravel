<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fields for Table
     * @return object Fields collection
     */
    public function fields()
    {
        return $this->hasMany('App\Models\Field');
    }
}
