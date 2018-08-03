<?php namespace App\Models\Entrust;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */

use Zizaco\Entrust\Contracts\EntrustRoleInterface;
use App\Models\Entrust\Traits\EntrustAdminRoleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class EntrustAdminRole extends Model implements EntrustRoleInterface
{
    use EntrustAdminRoleTrait;

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
        $this->table = Config::get('entrust.admin_roles_table');
    }

}
