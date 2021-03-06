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
    protected $guarded = ['id'];
    protected $appends = ['leave_type_name', 'sign_in_time_format', 'sign_out_time_format',
        'sign_in_status', 'sign_out_status', 'date_format'];

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
            } else {
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
            } else {
                if ($this->sign_out_time) {
                    $time_set = TimeSet::find($month);
                    $sign_time = Date::parse($this->sign_out_time)->format('H:i');
                    if ($sign_time >= $time_set['set_end_time']) {
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
            if ($this->getSignInStatusAttribute() == 1) {
                if ($admin_sign_apply && $admin_sign_apply->sign_apply_reason) {
                    return '已补签(' . $admin_sign_apply->sign_apply_reason . ')';
                } else {
                    return '已补签';
                }
            } elseif ($this->getSignInStatusAttribute() == 2) {
                return $sign_in_time . '<span style="color:#c12e2a;">(迟到)</span>';
            } else {
                return $sign_in_time;
            }
        } else {
            if ($this->getSignInStatusAttribute() == 1) {
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
            if ($this->getSignOutStatusAttribute() == 1) {
                if ($admin_sign_apply && $admin_sign_apply->sign_apply_reason) {
                    return '已补签(' . $admin_sign_apply->sign_apply_reason . ')';
                } else {
                    return '已补签';
                }
            } elseif ($this->getSignOutStatusAttribute() == 2) {
                return $sign_in_time . '<span style="color:#c12e2a;">(早退)</span>';
            } else {
                return $sign_in_time;
            }
        } else {
            if ($this->getSignOutStatusAttribute() == 1) {
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

    public function getDateFormatAttribute()
    {
        $date = $this->sign_date;
        $date_set = DateSet::find($date);
        $x = null;
        if ($date_set) {
            $x = '休';
        } else {
            $x = '班';
        }
        $n = Date::parse($date)->format('N');
        $m = null;
        switch ($n) {
            case 1:
                $m = '星期一(' . $x . ')';
                break;
            case 2:
                $m = '星期二(' . $x . ')';
                break;
            case 3:
                $m = '星期三(' . $x . ')';
                break;
            case 4:
                $m = '星期四(' . $x . ')';
                break;
            case 5:
                $m = '星期五(' . $x . ')';
                break;
            case 6:
                $m = '星期六(' . $x . ')';
                break;
            case 7:
                $m = '星期日(' . $x . ')';
                break;
            default:
                $m = null;
        }
        return $m;
    }
}