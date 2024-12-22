<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modem extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_perangkat',
        'lokasi_pemasangan',
        'tipe_modem',
        'status'
    ];
}
