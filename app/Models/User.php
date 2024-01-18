<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes,HasRoles ;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // to get list of permission group
    public static function getpermissionGroups()
    {
        $permission_group = DB::table('permissions')
                            ->select('group_name')
                            ->where('guard_name','web')
                            ->groupBy('group_name')
                            ->get();

        return $permission_group;
    }

    // get permission list by group name
    public static function getpermissionsByGroupName($group_name)
    {
        $permissions = DB::table('permissions')
                    ->select('id','name')
                    ->where('group_name',$group_name)
                    ->where('guard_name','web')
                    ->get();
        return $permissions;
    }

    // check weather permission is assigned to role
    public static function roleHasPermissions($role,$permissions)
    {
        $hasPermission = true;
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
                return $hasPermission;
            }
        }
        return $hasPermission;
    }
}
