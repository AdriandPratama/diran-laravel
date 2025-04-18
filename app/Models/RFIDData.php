<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFIDData extends Model
{
    use HasFactory;
    protected $table = 'rfid_data';

    protected $fillable = [
        'rfid_tag',
        'timestamp',
    ];
}
