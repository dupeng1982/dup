<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'certificate';
    public $timestamps = false;
    protected $fillable = ['admininfo_id', 'name', 'number', 'continue_password', 'study_password',
        'change_password', 'operator_id'];
}