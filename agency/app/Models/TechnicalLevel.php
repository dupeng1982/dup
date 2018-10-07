<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalLevel extends Model
{
    protected $table = 'technical_level';
    public $timestamps = false;
    protected $fillable = ['name'];
}