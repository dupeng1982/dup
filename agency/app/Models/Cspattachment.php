<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cspattachment extends Model
{
    protected $table = 'cspattachment';
    public $timestamps = false;
    protected $fillable = ['project_id', 'name', 'dir', 'operator_id', 'mimetype', 'check_status'];
}