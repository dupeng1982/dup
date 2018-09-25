<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLeave extends Model
{
    protected $table = 'admin_leave';
    public $timestamps = false;
    protected $fillable = ['admin_id', 'submit_time', 'leave_start_time', 'leave_end_time', 'leave_type',
        'leave_reason', 'leave_status', 'leave_approval', 'approval_time', 'approval_note'];
    protected $appends = ['leave_type_name'];

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
            return '请假';
        }
    }
}