<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfidMapping extends Model
{
    protected $fillable = ['tag', 'location'];
    public $timestamps = true;
}
