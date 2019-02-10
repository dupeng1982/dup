<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostSonProjectM extends Model
{
    protected $table = 'cost_sonproject';
    public $timestamps = true;
    protected $guarded = ['id', 'created_at', 'updated_at'];
}