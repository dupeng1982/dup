<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cpattachment extends Model
{
    protected $table = 'cpattachment';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $appends = ['check_name', 'operator_name'];

    public function getCheckNameAttribute()
    {
        //0-初始待分配，1-待审批，2-专项审核，3-负责人待审核，4-技术负责人待审核，5-结项待审核，6-结项
        if ($this->check_status == 0) {
            return '初始资料';
        } elseif ($this->check_status == 1) {
            return '分配审核资料';
        } elseif ($this->check_status == 2) {
            return '专项审核资料';
        } elseif ($this->check_status == 3) {
            return '负责人审核资料';
        } elseif ($this->check_status == 4) {
            return '技术审核资料';
        } elseif ($this->check_status == 5) {
            return '结项审核资料';
        } else {
            return '追加资料';
        }
    }

    public function getOperatorNameAttribute()
    {
        $admininfo = Admininfo::where('admin_id', $this->operator_id)->first();
        if ($admininfo) {
            return $admininfo->name;
        } else {
            return null;
        }

    }
}