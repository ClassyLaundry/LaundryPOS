<?php

namespace App\Models\Data;

use App\Models\User;
use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisRewash extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        JenisRewash::observe(new UserActionObserver);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'modified_by');
    }
}
