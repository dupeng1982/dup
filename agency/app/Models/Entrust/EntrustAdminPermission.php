<?php namespace App\Models\Entrust;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */

use Zizaco\Entrust\Contracts\EntrustPermissionInterface;
use App\Models\Entrust\Traits\EntrustAdminPermissionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class EntrustAdminPermission extends Model implements EntrustPermissionInterface
{
    use EntrustAdminPermissionTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('entrust.admin_permissions_table');
    }

}
