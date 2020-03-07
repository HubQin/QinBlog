<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'link', 'description'];
}
