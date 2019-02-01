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

class CostProject extends Model
{
    protected $table = 'cost_project';
    public $timestamps = true;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['number', 'status_txt'];

    public function getNumberAttribute()
    {
        return Date::parse($this->receive_date)->format('Y') . '-' . $this->id;
    }

    public function getStatusTxtAttribute()
    {
        //项目状态：0-初始待分配，1-待审批，3-负责人待审核，4-技术负责人待审核，5-结项待审核，6-结项
        if ($this->status == 1) {
            return '项目初审';
        } elseif ($this->status == 3) {
            return '项目负责人审核';
        } elseif ($this->status == 4) {
            return '技术负责人审核';
        } elseif ($this->status == 5) {
            return '结项审核';
        } elseif ($this->status == 6) {
            return '结项';
        } else {
            return '项目分配';
        }
    }

    public function profession()
    {
        return $this->belongsToMany('App\Models\Profession', 'profession_cost_project', 'project_id', 'profession_id');
    }

    public function sonproject()
    {
        return $this->hasMany('App\Models\CostSonProject', 'project_id', 'id');
    }

    public function contract()
    {
        return $this->hasOne('App\Models\Contract', 'id', 'contract_id');
    }
}