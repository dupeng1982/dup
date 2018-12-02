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
    protected $fillable = ['name', 'contract_id', 'service_id', 'cost', 'receive_date',
        'construction_id', 'agency_id', 'implement_id', 'remark', 'basic_rate', 'check_rate', 'check_cost_rate'];

    protected $appends = ['number'];

    public function getNumberAttribute()
    {
        return Date::parse($this->receive_date)->format('Y') . '-' . $this->id;
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