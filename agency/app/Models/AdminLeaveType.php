<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLeaveType extends Model
{
    protected $table = 'admin_leave_type';
    public $timestamps = false;
    protected $fillable = ['name'];
}