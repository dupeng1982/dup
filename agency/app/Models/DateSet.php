<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/7/27
 * Time: 12:22
 */

namespace App\Models;

use App\Models\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class DateSet extends Model
{
    use HasCompositePrimaryKey;
    protected $table = 'date_set';
    public $timestamps = false;
    public $primaryKey = ['sign_date', 'sign_date_type'];
    protected $fillable = ['sign_date', 'sign_date_type', 'date_status'];
}