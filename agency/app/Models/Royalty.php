<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Royalty extends Model
{
    protected $table = 'royalty';
    public $timestamps = false;
    protected $guarded = ['id'];
}