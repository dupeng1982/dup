<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = 'family';
    public $timestamps = false;
    protected $fillable = ['admininfo_id', 'name', 'relation', 'phone', 'operator_id'];
}