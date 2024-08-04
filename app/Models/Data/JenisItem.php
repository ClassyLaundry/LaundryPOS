<?php

namespace App\Models\Data;

use App\Models\Transaksi\ItemTransaksi;
use App\Models\User;
use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['nama_kategori'];

    public static function boot()
    {
        parent::boot();
        JenisItem::observe(new UserActionObserver);
    }

    public function getNamaKategoriAttribute()
    {
        $kategori = Kategori::find($this->kategori_id);
        return $kategori->nama;
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function item_transaksi()
    {
        return $this->hasMany(ItemTransaksi::class);
    }
}
