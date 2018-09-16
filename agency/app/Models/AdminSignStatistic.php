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

class AdminSignStatistic extends Model
{
    protected $table = 'admin_sign_statistic';
    public $timestamps = false;
    protected $fillable = ['admin_id', 'sign_date', 'sign_in_time', 'sign_in_status', 'sign_out_time',
        'sign_out_status', 'leave_type', 'leave_start_time', 'leave_end_time', 'leave_time', 'leave_time_type'];
    protected $appends = ['leave_type_name', 'sign_in_time_format', 'sign_out_time_format'];

    public function getLeaveTypeNameAttribute()
    {
        //请假类型：1-调休，2-事假，3-病假，4-出差，5-下现场
        if ($this->leave_type == 1) {
            return '调休';
        } elseif ($this->leave_type == 2) {
            return '事假';
        } elseif ($this->leave_type == 3) {
            return '病假';
        } elseif ($this->leave_type == 4) {
            return '出差';
        } elseif ($this->leave_type == 5) {
            return '下现场';
        } else {
            return null;
        }
    }

    private function getSignReason($admin_id, $date, $type)
    {
        return AdminSignApply::where([['admin_id', $admin_id], ['sign_apply_date', $date],
            ['sign_apply_type', $type]])->first();
    }

    public function getSignInTimeFormatAttribute()
    {
        $admin_sign_apply = $this->getSignReason($this->admin_id, $this->sign_date, 1);
        if ($this->sign_in_time) {
            $sign_in_time = Date::parse($this->sign_in_time)->format('H:i:s');
            //补签到状态：0-未补签，1-已补签，2-迟到
            if ($this->sign_in_status == 1) {
                if ($admin_sign_apply && $admin_sign_apply->sign_apply_reason) {
                    return '已补签(' . $admin_sign_apply->sign_apply_reason . ')';
                } else {
                    return '已补签';
                }
            } elseif ($this->sign_in_status == 2) {
                return $sign_in_time . '<span style="color:#c12e2a;">(迟到)</span>';
            } else {
                return $sign_in_time;
            }
        } else {
            if ($this->sign_in_status == 1) {
                if ($admin_sign_apply && $admin_sign_apply->sign_apply_reason) {
                    return '已补签(' . $admin_sign_apply->sign_apply_reason . ')';
                } else {
                    return '已补签';
                }
            } else {
                return '<span style="color:#c12e2a;">未签到</span>';
            }
        }
    }

    public function getSignOutTimeFormatAttribute()
    {
        $admin_sign_apply = $this->getSignReason($this->admin_id, $this->sign_date, 2);
        if ($this->sign_out_time) {
            $sign_in_time = Date::parse($this->sign_out_time)->format('H:i:s');
            //补签到状态：0-未补签，1-已补签，2-早退
            if ($this->sign_out_status == 1) {
                if ($admin_sign_apply && $admin_sign_apply->sign_apply_reason) {
                    return '已补签(' . $admin_sign_apply->sign_apply_reason . ')';
                } else {
                    return '已补签';
                }
            } elseif ($this->sign_out_status == 2) {
                return $sign_in_time . '<span style="color:#c12e2a;">(早退)</span>';
            } else {
                return $sign_in_time;
            }
        } else {
            if ($this->sign_out_status == 1) {
                if ($admin_sign_apply && $admin_sign_apply->sign_apply_reason) {
                    return '已补签(' . $admin_sign_apply->sign_apply_reason . ')';
                } else {
                    return '已补签';
                }
            } else {
                return '<span style="color:#c12e2a;">未签退</span>';
            }
        }
    }
}