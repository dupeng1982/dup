<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Date;

class AdminSign extends Model
{
    protected $table = 'admin_sign';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $appends = ['sign_status'];

    //获取签到状态
    public function getSignStatusAttribute()
    {
        $date = Date::parse($this->sign_time)->format('Y-m-d');
        $month = Date::parse($this->sign_time)->format('m');
        $date_set = DateSet::find($date);
        if ($date_set) {
            return 1;
        } else {
            $time_set = TimeSet::find($month);
            $sign_time = Date::parse($this->sign_time)->format('H:i');
            if ($this->sign_type == 1) {
                if ($sign_time <= $time_set['set_start_time']) {
                    return 1;
                } else {
                    return 0;
                }
            } elseif ($this->sign_type == 2) {
                if ($sign_time >= $time_set['set_end_time']) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }
}