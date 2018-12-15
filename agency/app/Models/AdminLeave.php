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
    protected $guarded = ['id'];
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