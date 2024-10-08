<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTransaksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab', 'id');
    }
}
