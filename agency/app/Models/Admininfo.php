<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admininfo extends Model
{
    protected $table = 'admininfo';
    public $timestamps = true;
    protected $fillable = ['admin_id', 'name', 'sex', 'birthday', 'work_status', 'work_year', 'work_start_date',
        'department_id', 'technical_level_id', 'admin_level_id', 'phone', 'level_id', 'level_type', 'cardno',
        'address', 'education_id', 'school', 'major', 'graduate_date', 'work_resume', 'study_resume', 'performance',
        'rewards', 'expertise', 'remark', 'avatar', 'operator_id'];

    protected $appends = ['work_status_name', 'department_name', 'technical_level_name', 'admin_level_name',
        'level_name', 'education_name', 'sex_name'];

    public function getWorkStatusNameAttribute()
    {
        $tmp = WorkStatus::find($this->work_status);
        if ($tmp) {
            return $tmp->name;
        } else {
            return null;
        }
    }

    public function getDepartmentNameAttribute()
    {
        $tmp = Department::find($this->department_id);
        if ($tmp) {
            return $tmp->name;
        } else {
            return null;
        }
    }

    public function getTechnicalLevelNameAttribute()
    {
        $tmp = TechnicalLevel::find($this->technical_level_id);
        if ($tmp) {
            return $tmp->name;
        } else {
            return null;
        }
    }

    public function getAdminLevelNameAttribute()
    {
        $tmp = AdminLevel::find($this->admin_level_id);
        if ($tmp) {
            return $tmp->name;
        } else {
            return null;
        }
    }

    public function getLevelNameAttribute()
    {
        $tmp = Level::find($this->level_id);
        if ($tmp) {
            return $tmp->name;
        } else {
            return null;
        }
    }

    public function getEducationNameAttribute()
    {
        $tmp = Education::find($this->education_id);
        if ($tmp) {
            return $tmp->name;
        } else {
            return null;
        }
    }

    public function professions()
    {
        return $this->belongsToMany('App\Models\Profession', 'profession_admin', 'admininfo_id', 'profession_id');
    }

    public function family()
    {
        return $this->hasMany('App\Models\Family', 'admininfo_id', 'id');
    }

    public function certificate()
    {
        return $this->hasMany('App\Models\Certificate', 'admininfo_id', 'id');
    }

    public function attachment()
    {
        return $this->hasMany('App\Models\AdmininfoPic', 'admininfo_id', 'id');
    }

    public function getSexNameAttribute()
    {
        if ($this->sex == 1) {
            return '男';
        } else {
            return '女';
        }
    }
}