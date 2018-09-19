<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admininfo extends Model
{
    protected $table = 'admininfo';
    public $timestamps = true;
    protected $fillable = ['admin_id', 'name', 'sex'];
}