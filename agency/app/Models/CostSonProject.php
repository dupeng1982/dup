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
    protected $appends = ['profession_name', 'profession', 'status_txt', 'marchers', 'rates'];

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
}