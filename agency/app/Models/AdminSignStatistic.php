<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSignStatistic extends Model
{
    protected $table = 'admin_sign_statistic';
    public $timestamps = false;
    protected $fillable = ['admin_id', 'sign_date', 'sign_in_time', 'sign_in_status', 'sign_out_time',
        'sign_out_status', 'leave_type', 'leave_start_time', 'leave_end_time', 'leave_time'];

    public function getLeaveTypeNameAttribute($value)
    {
        //请假类型：1-调休，2-事假，3-病假，4-出差，5-下现场
        if ($value == 1) {
            return '调休';
        } elseif ($value == 2) {
            return '事假';
        } elseif ($value == 3) {
            return '病假';
        } elseif ($value == 4) {
            return '出差';
        } elseif ($value == 5) {
            return '下现场';
        } else {
            return null;
        }
    }
}