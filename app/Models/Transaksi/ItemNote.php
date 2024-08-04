<?php

namespace App\Models\Transaksi;

use App\Models\User;
use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemNote extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = [
        'nama_user'
    ];

    public function getNamaUserAttribute()
    {
        $user = User::find($this->modified_by);
        return $user->name;
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public static function boot()
    {
        parent::boot();
        ItemNote::observe(new UserActionObserver);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item_transaksi()
    {
        return $this->belongsTo(ItemTransaksi::class);
    }
}
