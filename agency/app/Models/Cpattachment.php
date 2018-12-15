<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cpattachment extends Model
{
    protected $table = 'cpattachment';
    public $timestamps = false;
    protected $guarded = ['id'];
}