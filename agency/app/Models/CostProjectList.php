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

class CostProjectList extends Model
{
    protected $table = 'cost_project';
    public $timestamps = true;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['number', 'status_txt', 'show_check', 'check_money', 'service_money'];

    //核定费率
    public function getCheckCostRateAttribute($value)
    {
        if ($value) {
            return $value;
        } else {
            return $this->service->check_cost_rate;
        }
    }

    //核定率
    public function getCheckRateAttribute($value)
    {
        if ($value) {
            return $value;
        } else {
            return $this->service->check_rate;
        }
    }

    //基础费率
    public function getBasicRateAttribute($value)
    {
        if ($value) {
            return $value;
        } else {
            return $this->getGrade();
        }
    }

    private function getGrade()
    {
        $cost_tmp = $this->cost ?: $this->getCost();
        if ($cost_tmp <= 100) {
            return $this->service->grade1;
        } elseif ($cost_tmp <= 500) {
            return $this->service->grade2;
        } elseif ($cost_tmp <= 1000) {
            return $this->service->grade3;
        } elseif ($cost_tmp <= 2000) {
            return $this->service->grade4;
        } elseif ($cost_tmp <= 5000) {
            return $this->service->grade5;
        } elseif ($cost_tmp <= 10000) {
            return $this->service->grade6;
        } else {
            return $this->service->grade7;
        }
    }

    //服务收费
    public function getServiceMoneyAttribute()
    {
        $cost = $this->cost ?: $this->getCost();
        $check_cost = $this->check_cost ?: $this->getCheckCost();
        $grade = $this->basic_rate ?: $this->getGrade();
        if ($this->service_id == 19) {
            $check_rate = $this->check_rate ?: $this->service->check_rate;
            $check_cost_rate = $this->check_cost_rate ?: $this->service->check_cost_rate;
            $money = (($cost * $grade) / 1000);
            $tmp1 = $cost * $check_rate / 100;
            $tmp2 = abs($check_cost - $cost);
            if ($tmp2 > $tmp1) {
                $money = $money + (($tmp2 - $tmp1) * $check_cost_rate / 100);
            }
        } else {
            $money = ($cost * $grade) / 1000;
        }
        $min_profit = $this->min_profit / 10000;
        if ($money < $min_profit) {
            $money = $min_profit;
        }
        return round($money, 4);
    }

    //收费基数
    public function getCostAttribute($value)
    {
        if ($value) {
            return $value;
        } else {
            return $this->getCost();
        }
    }

    private function getCost()
    {
        return $this->sonproject->sum('cost');
    }

    //核定基数
    public function getCheckCostAttribute($value)
    {
        if ($value) {
            return $value;
        } else {
            return $this->getCheckCost();
        }
    }

    private function getCheckCost()
    {
        return $this->sonproject->sum('check_cost');
    }

    //核减核增额
    public function getCheckMoneyAttribute()
    {
        $cost = $this->cost ?: $this->getCost();
        $check_cost = $this->check_cost ?: $this->getCheckCost();
        if ($this->service_id == 19) {
            return $check_cost - $cost;
        } else {
            return 0;
        }
    }

    public function getShowCheckAttribute()
    {
        $data = $this->sonproject->where('status', '<>', 3)->first();
        if ($data) {
            return 0;
        } else {
            return 1;
        }
    }

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

    public function service()
    {
        return $this->hasOne('App\Models\Service', 'id', 'service_id');
    }
}