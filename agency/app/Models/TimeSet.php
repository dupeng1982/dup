<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSet extends Model
{
    protected $table = 'time_set';
    protected $primaryKey = 'set_month';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['set_month', 'set_start_time', 'set_end_time'];
}