<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contract';
    public $timestamps = true;
    protected $fillable = ['name', 'type', 'number', 'address', 'start_date', 'end_date',
        'construction_id', 'agency_id', 'content', 'remark', 'sign_date'];

    protected $appends = ['contract_type_name'];

    public function getContractTypeNameAttribute()
    {
        $tmp = ContractType::find($this->type);
        if ($tmp) {
            return $tmp->name;
        } else {
            return '其他';
        }
    }
}