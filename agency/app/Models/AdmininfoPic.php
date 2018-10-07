<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmininfoPic extends Model
{
    protected $table = 'admininfo_pic';
    public $timestamps = false;
    protected $fillable = ['admininfo_id', 'name', 'dir', 'operator_id'];
}