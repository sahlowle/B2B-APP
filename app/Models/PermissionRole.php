<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cache;
use Illuminate\Support\Facades\DB;

class PermissionRole extends Model
{
    use HasFactory;

    protected $fillable = ['permission_id', 'role_id'];

    public $timestamps = false;

    private static $permissionNames = [];

    /**
     * store
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        if (self::create($data)) {
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * remove permission role
     *
     * @param  object  $data
     * @return bool
     */
    public function remove($data)
    {
        if ($data->delete()) {
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * permission names by role id
     *
     * @param  int  $roleId
     * @return array
     */
    public static function permissionNamesByRoleID($roleId)
    {
        if (isset(static::$permissionNames[$roleId])) {
            return static::$permissionNames[$roleId];
        }

        $data = Cache::get(config('cache.prefix') . '-permission-name-by-role-' . $roleId);

        if (empty($data)) {
            if ($roleId == 1) {
                $data = DB::table('permissions')->select('name')->pluck('name')->toArray();
            } else {
                $data = DB::table('permissions')
                    ->join('permission_roles', 'permissions.id', '=', 'permission_roles.permission_id')
                    ->where('permission_roles.role_id', $roleId)
                    ->pluck('permissions.name')
                    ->toArray();
            }

            Cache::put(config('cache.prefix') . '-permission-name-by-role-' . $roleId, $data, 30 * 86400);
        }

        static::$permissionNames = [$roleId => $data];

        return $data;
    }
}
