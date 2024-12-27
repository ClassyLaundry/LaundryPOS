<?php

namespace App\Models\Transaksi;

use App\Models\Transaksi\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomplainTransaksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = ['id_transaksi', 'komplain', 'status', 'resolve_at', 'created_by'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}
