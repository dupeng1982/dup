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
    protected $guarded = ['id'];
    protected $appends = ['late_num', 'left_early_num', 'sign_day_sum', 'date_attendance_time',
        'date_other_time', 'date_leave_time', 'date_leave_day', 'sign_out_status', 'sign_in_status'];

    public function getSignInStatusAttribute()
    {
        $date = $this->sign_date;
        $month = Date::parse($date)->format('m');
        $date_set = DateSet::find($date);
        if ($date_set) {
            return 0;
        } else {
            $admin_sign_apply = AdminSignApply::where([['admin_id', $this->admin_id], ['sign_apply_date', $date],
                ['sign_apply_type', 1], ['sign_apply_status', 1]])->first();
            if ($admin_sign_apply) {
                return 1;
            }else{
                if ($this->sign_in_time) {
                    $time_set = TimeSet::find($month);
                    $sign_time = Date::parse($this->sign_in_time)->format('H:i');
                    if ($sign_time <= $time_set['set_start_time']) {
                        return 0;
                    } else {
                        return 2;
                    }
                } else {
                    return 0;
                }
            }
        }
    }

    public function getSignOutStatusAttribute()
    {
        $date = $this->sign_date;
        $month = Date::parse($date)->format('m');
        $date_set = DateSet::find($date);
        if ($date_set) {
            return 0;
        } else {
            $admin_sign_apply = AdminSignApply::where([['admin_id', $this->admin_id], ['sign_apply_date', $date],
                ['sign_apply_type', 2], ['sign_apply_status', 1]])->first();
            if ($admin_sign_apply) {
                return 1;
            }else{
                if ($this->sign_out_time) {
                    $time_set = TimeSet::find($month);
                    $sign_time = Date::parse($this->sign_out_time)->format('H:i');
                    if ($sign_time >= $time_set['set_start_time']) {
                        return 0;
                    } else {
                        return 2;
                    }
                } else {
                    return 0;
                }
            }
        }
    }

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

    //获取当月的设置考勤时间
    private function _getMonthSetTime($month)
    {
        $month = Date::parse($month)->format('m');
        return TimeSet::find($month);
    }

    private function _getTimeSub($start, $end)
    {
        return round(Date::parse($end)->timespanm($start) / 60, 1);
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
        $rs = 0;
        $set_date = $this->_getMonthSetTime($this->sign_date);
        if ((($this->sign_in_status == 1) || ($this->sign_in_time)) &&
            (($this->sign_out_status == 1) || ($this->sign_out_time))
        ) {
            if ($this->sign_in_status == 1) {
                $start = $set_date['set_start_time'];
            } else {
                $start = Date::parse($this->sign_in_time)->format('H:i');
            }
            if ($this->sign_out_status == 1) {
                $end = $set_date['set_end_time'];
            } else {
                $end = Date::parse($this->sign_out_time)->format('H:i');
            }
            $rs = $rs + $this->_getTimeSub($start, $end);

            if ($end < $set_date['set_end_time']) {
                if ((($this->leave_type == 4) || ($this->leave_type == 5)) && ($this->leave_time_type != 1) && $this->leave_time) {
                    $tmp_arr = explode('-', $this->leave_time);
                    $rs = $rs + $this->_getTimeSub($tmp_arr[0], $tmp_arr[1]);
                }
            }
        } elseif ((($this->leave_type == 4) || ($this->leave_type == 5)) && ($this->leave_time_type == 1) && $this->leave_time) {
            $tmp_arr = explode('-', $this->leave_time);
            $rs = $rs + $this->_getTimeSub($tmp_arr[0], $tmp_arr[1]);
        } else {
            $rs = 0;
        }
        return $rs;
    }

    //获取加班时间
    public function getDateOtherTimeAttribute()
    {
        if ($this->sign_out_time) {
            $set_date = $this->_getMonthSetTime($this->sign_date);
            $end = Date::parse($this->sign_out_time)->format('H:i');
            if ($end > $set_date['set_end_time']) {
                $rs = $this->_getTimeSub($set_date['set_end_time'], $end);
                return $rs;
            }
        }
        return 0;
    }

    //获取请假时间
    public function getDateLeaveTimeAttribute()
    {
        if (($this->leave_type != 4) && ($this->leave_type != 5) && $this->leave_time) {
            $tmp_arr = explode('-', $this->leave_time);
            $rs = $this->_getTimeSub($tmp_arr[0], $tmp_arr[1]);
        } else {
            $rs = 0;
        }
        return $rs;
    }

    //获取请假天数
    public function getDateLeaveDayAttribute()
    {
        if ((($this->leave_type == 1) || ($this->leave_type == 2) || ($this->leave_type == 3)) && $this->leave_time) {
            if ($this->leave_time_type == 1) {
                $rs = 1;
            } elseif ($this->leave_time_type == 2) {
                $tmp_arr = explode('-', $this->leave_time);
                $rs = round($this->_getTimeSub($tmp_arr[0], $tmp_arr[1]) / 9, 1);
            } else {
                $rs = 0;
            }
        } else {
            $rs = 0;
        }
        return $rs;
    }
}