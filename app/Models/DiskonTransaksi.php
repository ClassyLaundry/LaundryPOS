<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskonTransaksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function diskon()
    {
        return $this->belongsTo(Diskon::class);
    }
}
