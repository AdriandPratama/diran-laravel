<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataLog extends Model
{
    protected $fillable = ['name', 'ip', 'location', 'tag'];
}

