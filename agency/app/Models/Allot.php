<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allot extends Model
{
    protected $table = 'allot';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $appends = ['operator_name'];

    public function getOperatorNameAttribute()
    {
        return AdmininfoM::where('admin_id', $this->operator_id)->pluck('name')->first();
    }
}