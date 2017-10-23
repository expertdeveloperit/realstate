<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyDetail extends Model
{
    protected $table = 'property_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pid','last_date'];
}
