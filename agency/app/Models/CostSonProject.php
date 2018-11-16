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
    protected $fillable = ['project_id', 'profession_id', 'name', 'number', 'cost', 'check_cost', 'remark'];

    protected $appends = ['profession_name'];

    public function getProfessionNameAttribute()
    {
        $profession = Profession::find($this->profession_id);
        return $profession->name;
    }
//
//    public function profession()
//    {
//        return $this->belongsToMany('App\Models\Profession', 'profession_cost_project', 'project_id', 'profession_id');
//    }
//
//    public function sonproject()
//    {
//        return $this->hasMany('App\Models\CostSonProject', 'project_id', 'id');
//    }
}