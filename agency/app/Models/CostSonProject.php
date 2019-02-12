<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostSonProject extends Model
{
    protected $table = 'cost_sonproject';
    public $timestamps = true;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $appends = ['profession_name', 'profession', 'status_txt', 'marchers', 'rates',
        'project_allot_money', 'check_allot_money', 'check_result_txt'];

    public function getStatusTxtAttribute()
    {
        //项目状态：0-待分配，1-待初审，2-实施人待审核，3-结项
        if ($this->status == 1) {
            return '项目初审';
        } elseif ($this->status == 2) {
            return '项目实施人审核';
        } elseif ($this->status == 3) {
            return '结项';
        } else {
            return '项目分配';
        }
    }

    public function getCheckResultTxtAttribute()
    {
        //考核结果：0-未考核，1-合格，2-不合格
        if ($this->check_result == 1) {
            return '合格';
        } elseif ($this->check_result == 2) {
            return '不合格';
        } else {
            return '未考核';
        }
    }

    public function getProfessionNameAttribute()
    {
        $profession = Profession::find($this->profession_id);
        return $profession->name;
    }

    public function getProfessionAttribute()
    {
        $project = CostProject::find($this->project_id);
        return $project->profession;
    }

    public function getMarchersAttribute()
    {
        return Profession::with('marchers')
            ->where('id', $this->profession_id)
            ->first()->marchers;
    }

    public function getRatesAttribute()
    {
        return Royalty::where('profession_id', $this->profession_id)
            ->where('type', 1)->first();
    }

    public function getProjectAllotMoneyAttribute()
    {
        //获取主项收费基数
        $cost_project = CostProject::find($this->project_id);
        if ($cost_project) {
            $cost = $cost_project->cost;
        } else {
            $cost = 0;
        }
        //获取专项收费基数和
        $max = CostSonProjectM::where('project_id', $this->project_id)->sum('cost');
        //求最大收费基数
        if ($cost > $max) {
            $max = $cost;
        }
        if (!$max) {
            return 0;
        }
        //获取总分配金额
        $allot_money = Allot::where('project_id', $this->project_id)->sum('money');
        //返回子分配金额
        $money = ($allot_money * $this->cost * $this->basic_rate) / ($max * 100);
        return $money;
    }

    public function getCheckAllotMoneyAttribute()
    {
        //获取主项收费基数
        $cost_project = CostProject::find($this->project_id);
        if ($cost_project) {
            $cost = $cost_project->cost;
        } else {
            $cost = 0;
        }
        //获取专项收费基数和
        $max = CostSonProjectM::where('project_id', $this->project_id)->sum('cost');
        //求最大收费基数
        if ($cost > $max) {
            $max = $cost;
        }
        if (!$max || $this->check_result != 1) {
            return 0;
        }
        //获取总分配金额
        $allot_money = Allot::where('project_id', $this->project_id)->sum('money');
        //返回子分配金额
        $money = ($allot_money * $this->cost * $this->check_rate) / ($max * 100);
        return $money;
    }
}