<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    protected $table = 'profession';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function marchers()
    {
        return $this->belongsToMany('App\Models\AdmininfoM', 'profession_admin', 'profession_id', 'admininfo_id')
            ->where('work_status','<>', 3)
            ->select('admin_id', 'name');
    }
}