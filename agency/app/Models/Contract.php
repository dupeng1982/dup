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

class Contract extends Model
{
    protected $table = 'contract';
    public $timestamps = true;
    protected $fillable = ['name', 'type', 'address', 'start_date', 'end_date',
        'construction_id', 'agency_id', 'content', 'remark', 'sign_date'];

    protected $appends = ['contract_type_name', 'number', 'number_name'];

    public function getContractTypeNameAttribute()
    {
        $tmp = ContractType::find($this->type);
        if ($tmp) {
            return $tmp->name;
        } else {
            return '其他';
        }
    }

    public function getNumberAttribute()
    {
        return Date::parse($this->sign_date)->format('Y') . '-' . $this->id;
    }

    public function getNumberNameAttribute()
    {
        $contract_type = ContractType::find($this->type);
        return $contract_type->short . '[' . Date::parse($this->sign_date)->format('Y') . ']第' . $this->id . '号';
    }

    public function construction()
    {
        return $this->hasOne('App\Models\Company', 'id', 'construction_id');
    }

    public function agency()
    {
        return $this->hasOne('App\Models\Company', 'id', 'agency_id');
    }
}