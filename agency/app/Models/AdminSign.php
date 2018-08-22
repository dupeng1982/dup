<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSign extends Model
{
    protected $table = 'admin_sign';
    public $timestamps = false;
    protected $fillable = ['admin_id', 'sign_time', 'sign_type'];
}