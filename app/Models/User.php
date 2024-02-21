<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Observers\UserActionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Transaksi\Transaksi;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'address',
        'phone',
        'status',
        'outlet_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['role'];

    public static function boot()
    {
        parent::boot();
        User::observe(new UserActionObserver);
    }

    public function getRoleAttribute()
    {
        return $this->getRole($this->id);
    }

    public static function getRole($id)
    {
        $user = User::find($id);
        $roles = $user->getRoleNames();
        if (count($roles) == 0) {
            return "error";
        } else {
            return $roles[0];
        }
    }

    public static function getOutletId($id)
    {
        $user = User::find($id);
        return $user->outlet_id;
    }

    public function changeRole($role)
    {
        $current_role = $this->getRole($this->id);
        $this->removeRole($current_role);
        $this->assignRole($role);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function cucian()
    {
        return $this->hasMany(Transaksi::class, 'pencuci', 'id');
    }

    public function setrikaan()
    {
        return $this->hasMany(Transaksi::class, 'penyetrika', 'id');
    }
}
