<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
     protected $table = 'properties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pid','last_date'];
}
