<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class RolePermissionSeeder.
 *
 * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/multiple-guards
 *
 * @package App\Database\Seeds
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Enable these options if you need same role and other permission for User Model
         * Else, please follow the below steps for admin guard
         */
        
         // Admin panel permissions        
        $permissions = [
        // Permission List as array
            [
                'guard_name' => 'web',
                'group_name' => 'user',
                'permissions' => [
                    // App Permissions
                    'user-access',
                    'user-create',
                    'user-edit',
                    'user-delete',
                    'user-status',
                ]
            ],  
            [
                'guard_name' => 'web',
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role-access',
                    'role-create',
                    'role-view',
                    'role-edit',
                    'role-delete'
                ]
            ],       
        ];
        
        $check_role = Role::where('name','Admin')->where('guard_name','web')->first();
        if(is_null($check_role) || empty($check_role) || $check_role == ""){            
            // Do same for the admin guard for tutorial purposes
            $roleSuperAdmin = Role::create(['name' => 'Admin','guard_name' => 'web']);

            // Create and Assign Permissions
            for ($i = 0; $i < count($permissions); $i++) {
                $permissionGroup = $permissions[$i]['group_name'];
                $permissionGuard = $permissions[$i]['guard_name'];
                for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                    // Create Permission
                    $permission = Permission::create(['guard_name' => $permissionGuard,'name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
                    $roleSuperAdmin->givePermissionTo($permission);
                    $permission->assignRole($roleSuperAdmin);
                }
            }
        
            // Assign  role permission to admin user
            $admin =  User::where('email','admin@gmail.com')->first(); 
            if ($admin) {
                $admin->assignRole($roleSuperAdmin);
            }
        }        
    }
}
