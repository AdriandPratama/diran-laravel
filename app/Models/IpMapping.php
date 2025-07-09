<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpMapping extends Model
{
    protected $fillable = ['ip', 'name'];
    public $timestamps = true;
}
