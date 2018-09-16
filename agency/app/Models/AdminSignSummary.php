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

class AdminSignSummary extends Model
{
    protected $table = 'admin_sign_statistic';
    public $timestamps = false;
    protected $fillable = ['admin_id', 'sign_date', 'sign_in_time', 'sign_in_status', 'sign_out_time',
        'sign_out_status', 'leave_type', 'leave_start_time', 'leave_end_time', 'leave_time', 'leave_time_type'];
    protected $appends = ['late_num', 'left_early_num', 'sign_day_sum', 'date_attendance_time',
        'date_other_time', 'date_leave_time'];

    //获取迟到次数
    public function getLateNumAttribute()
    {
        if ($this->sign_in_status == 2) {
            return 1;
        }
        return 0;
    }

    //获取早退次数
    public function getLeftEarlyNumAttribute()
    {
        if ($this->sign_out_status == 2) {
            return 1;
        }
        return 0;
    }

    //获取实际出勤天数
    public function getSignDaySumAttribute()
    {
        if (((($this->sign_in_status == 1) || ($this->sign_in_time)) && (($this->sign_out_status == 1) || ($this->sign_out_time))) ||
            ((($this->leave_type == 4) || ($this->leave_type == 5)) && ($this->leave_time_type == 1))
        ) {
            return 1;
        }
        return 0;
    }

    //获取实际出勤时间
    public function getDateAttendanceTimeAttribute()
    {
        return 123;
    }

    //获取加班时间
    public function getDateOtherTimeAttribute()
    {
        return 456;
    }

    //获取请假时间
    public function getDateLeaveTimeAttribute()
    {
        return 789;
    }
}