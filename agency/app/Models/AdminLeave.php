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
        $tmp = AdminLeaveType::find($this->leave_type);
        if ($tmp) {
            return $tmp->name;
        } else {
            return '请假';
        }
    }
}