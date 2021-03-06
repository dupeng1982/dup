<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSignApply extends Model
{
    protected $table = 'admin_sign_apply';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function getSignApplyTypeNameAttribute($value)
    {
        //补签类型：1-补到签，2-补退签
        if ($value == 1) {
            return '补到签';
        } elseif ($value == 2) {
            return '补退签';
        } else {
            return null;
        }
    }
}