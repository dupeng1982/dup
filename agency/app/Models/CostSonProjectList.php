<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostSonProjectList extends Model
{
    protected $table = 'cost_sonproject';
    public $timestamps = true;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $appends = ['profession_name', 'project_allot_money', 'check_allot_money', 'check_result_name'];

    public function getProfessionNameAttribute()
    {
        $profession = Profession::find($this->profession_id);
        return $profession->name;
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
        $allot_money = Allot::where('project_id', $this->project_id)
            ->where($this->getYearArr())->sum('money');
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
        $allot_money = Allot::where('project_id', $this->project_id)
            ->where($this->getYearArr())->sum('money');
        //返回子分配金额
        $money = ($allot_money * $this->cost * $this->check_rate) / ($max * 100);
        return $money;
    }

    public function getCheckResultNameAttribute()
    {
        //考核结果：0-未考核，1-通过，2-不合格
        if ($this->check_result == 1) {
            return '通过';
        } elseif ($this->check_result == 2) {
            return '不合格';
        } else {
            return '未考核';
        }
    }

    private function getYearArr()
    {
        $arr = array();
        $this->allot_year && array_push($arr, ['allot_year', '=', $this->allot_year]);
        return $arr;
    }
}