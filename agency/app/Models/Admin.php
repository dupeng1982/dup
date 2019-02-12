<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Entrust\Traits\EntrustAdminTrait;

class Admin extends Authenticatable
{
    use Notifiable, EntrustAdminTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'is_attendance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['admininfo', 'project_info', 'sonproject_info'];

    public function getAdmininfoAttribute()
    {
        return Admininfo::where('admin_id', $this->id)->first();
    }

    public function getProjectInfoAttribute()
    {
        //项目状态：0-初始待分配，1-待审批，3-负责人待审核，4-技术负责人待审核，5-结项待审核，6-结项
        return CostProject::distinct('status')->where('checker_id', $this->id)
            ->whereIn('status', [3, 4, 5])->pluck('status')->toArray();
    }

    public function getSonprojectInfoAttribute()
    {
        //项目状态：0-初始待分配，1-待审批，2-实施人待审核，3-结项
        return CostSonProjectM::distinct('status')->where('checker_id', $this->id)
            ->whereIn('status', [1, 2])->pluck('status')->toArray();
    }


}
