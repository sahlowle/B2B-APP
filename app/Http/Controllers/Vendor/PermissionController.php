<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\{
    Permission,
    PermissionRole,
    Role
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Permissions
     */
    public function index(): View
    {

        $permissionRole = PermissionRole::getAll();
        $permissions = Permission::getAll()->whereIn('id', $permissionRole->pluck('permission_id')->toArray())->sortBy('controller_name');
        $permissionRole = $permissionRole->toArray();
        $vendorId = session('vendorId') ?: auth()->user()->vendor()->vendor_id;
        $prms = [];
        $modules = [];

        foreach (\Nwidart\Modules\Facades\Module::getOrdered() as $key => $value) {
            $modules[] = 'Modules\\' . $key;
        }
        foreach ($permissions as $permission) {
            $group = explode('Controller', $permission->controller_name)[0];

            if (! array_key_exists($group, $prms)) {
                $type = [
                    'vendor' => 'App\Http\Controllers\Vendor\\',
                    'customer' => 'App\Http\Controllers\Site\\',
                    'customer_api' => 'App\Http\Controllers\Api\User\\',
                    'vendor_api' => 'App\Http\Controllers\Api\Vendor\\',
                    'admin_api' => 'App\Http\Controllers\Api\\',
                ];

                $prms[$group]['admin'] = [];
                foreach ($type as $key => $value) {
                    $prms[$group][$key] = [];
                }
            }
            foreach ($type as $key => $value) {
                $path = str_replace($modules, 'App', $permission->controller_path);

                if (strpos($path, $value) !== false) {
                    array_push($prms[$group][$key], [
                        'id' => $permission->id,
                        'name' => $permission->method_name,
                        'role_ids' => $this->rolesByPermission($permissionRole, $permission->id),
                    ]);

                    continue 2;
                }
            }

            if ($permission->controller_path == 'Modules\MediaManager\Http\Controllers\MediaManagerController' && $permission->method_name == 'store') {
                array_push($prms[$group]['vendor'], [
                    'id' => $permission->id,
                    'name' => $permission->method_name,
                    'role_ids' => $this->rolesByPermission($permissionRole, $permission->id),
                ]);
            }
        }
        $data['list_menu'] = 'permission';
        $data['permissions'] = $prms;
        $data['roles'] = Role::where(['type' => 'vendor', 'vendor_id' => $vendorId])->get()->toArray();

        return view('vendor.permission.index', $data);
    }

    /**
     * rolesByPermission description
     */
    public function rolesByPermission(array $rolePermissions, int $permissionID): array
    {
        $roleIDs = [];

        foreach ($rolePermissions as $rolePermission) {
            if ($rolePermission['permission_id'] == $permissionID && ! in_array($rolePermission['role_id'], $roleIDs)) {
                array_push($roleIDs, $rolePermission['role_id']);
            }
        }

        return $roleIDs;
    }

    /**
     * assignPermission description
     */
    public function assign(Request $request)
    {
        if (! isset($request->role_id) && ! isset($request->permission_id)) {
            return response()->json(false);
        }

        if ($request->role_id == 1) {
            return response()->json(false);
        }

        $isPrmsRoleExit = PermissionRole::where([
            'permission_id' => $request->permission_id,
            'role_id' => $request->role_id,
        ]);

        if ($isPrmsRoleExit->first()) {
            (new PermissionRole())->remove($isPrmsRoleExit);
            Cache::forget(config('cache.prefix') . '-permission-role');
            Cache::forget(config('cache.prefix') . '-permission-name-by-role-' . $request->role_id);

            return response()->json(true);
        }

        (new PermissionRole())->store($request->only('permission_id', 'role_id'));
        Cache::forget(config('cache.prefix') . '-permission-role');
        Cache::forget(config('cache.prefix') . '-permission-name-by-role-' . $request->role_id);

        return response()->json(true);
    }
}
