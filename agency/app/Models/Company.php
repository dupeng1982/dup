<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';
    public $timestamps = true;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['company_type_name'];

    public function getCompanyTypeNameAttribute()
    {
        $tmp = CompanyType::find($this->type);
        if ($tmp) {
            return $tmp->name;
        } else {
            return '其他';
        }
    }
}