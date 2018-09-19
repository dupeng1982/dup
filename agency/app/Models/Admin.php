<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Entrust\Traits\EntrustAdminTrait;

class Admin extends Authenticatable
{
    use Notifiable, EntrustAdminTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'is_attendance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['admininfo'];

    public function getAdmininfoAttribute()
    {
        $admin = Admininfo::find($this->id);
        if ($admin) {
            return $admin;
        } else {
            return null;
        }
    }
}
