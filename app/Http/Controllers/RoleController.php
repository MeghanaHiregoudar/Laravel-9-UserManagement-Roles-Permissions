<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Log;
use App\Helpers\Core;
use App\Models\User;


class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-access', ['only' => ['index','getRolesData']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        $this->middleware('permission:role-view', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roles.roles_list');
    }

    public function getRolesData(Request $request)
    {
        if ($request->ajax()) {         
            $roles = Role::where('guard_name','web');
            $roles =$roles->with('permissions')->get();
            
            return Datatables::of($roles)
                ->addIndexColumn()
                ->addColumn('permission', function($roles) {
                    return $roles->permissions->map(function($permission) {
                        return '<span class="badge badge-info mr-1">' . $permission->name . '</span>';
                    })->implode(' ');
                })    
                ->addColumn('action', function($row){      

                    $editBtn = '';
                    if (auth()->user()->hasPermissionTo('role-edit') && $row->name!='Admin') {
                        $editBtn .= '<a class="action_btn btn btn-sm bg-indigo rounded-circle p-2 round_btn" target="_self" id="edit_user_btn" href="'.route("role_edit",[$row->id]).'"><i class="fas fa-pencil-alt"></i></a>';
                    }

                    $deleteBtn = '';
                    if (auth()->user()->hasPermissionTo('role-delete') && $row->name!='Admin') {
                        $deleteBtn .= '<button type="button"  class="action_btn btn btn-sm btn-danger round_btn rounded-circle p-2 " value="'.$row->id.'" id="delete_role_btn"><i class="fas fa-trash-alt"></i></button>';
                    }

                    $actionBtn = '<ul class="listing line">  <li class="mr-2 ml-2">'.$editBtn.'</li> <li class="mr-2 ml-2">'.$deleteBtn.'</li></ul>';
                    return $actionBtn;
                    
                })
                ->rawColumns(['permission','action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['all_permissions'] = Permission::where('guard_name','web')->get();
        $data['permission_groups'] = User::getpermissionGroups();
        return view('roles.role_create',$data);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Data
        $request->validate([
            'name' => 'required|max:50||regex:/^[a-zA-Z ]*$/|unique:roles'
        ], [
            'name.required' => trans('validation.custom.name.required',['attribute' => 'Role name']),
            'name.max' => trans('validation.custom.name.max',['max' => 50]),
            'name.regex' => trans('validation.custom.name.regex'),
            'name.unique' => trans('validation.custom.name.unique',['attribute' => 'Role name']),
        ]);

        // create role
        $role = Role::create(['name' => $request->name,'guard_name'=>'web']);

        $permissions = $request->permissions;

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }
  
        return redirect()->route('roles_list')->with('success', trans('message.role-added-successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['role'] = Role::where('guard_name','web')->find($id); 
       
        $data['all_permissions'] = Permission::where('guard_name','web')->get();
        $data['permission_groups'] = User::getpermissionGroups();
        return view('roles.role_edit',$data);
        
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $role_id = $request->role_id;
        $role = Role::find($role_id);
        if(!$role) {
            return redirect()->route('admin.roles_list')->with('error',trans('message.role-detail-not-found'));
        } else {
            // Validation Data
            $request->validate([
                'name' => 'required|max:100|unique:roles,name,'.$role_id
            ], [
                'name.required' => trans('validation.custom.name.required',['attribute' => 'Role name']),
                'name.max' => trans('validation.custom.name.max',['max' => 50]),
                'name.regex' => trans('validation.custom.name.regex'),
                'name.unique' => trans('validation.custom.name.unique',['attribute' => 'Role name']),
            ]);
            $role->update(['name'=>$request->name]);

            $permissions = $request->permissions;

            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            }
            return redirect()->route('roles_list')->with('success', trans('message.role-update-successfully'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $role_id = $request->role_id;
            $role = Role::find($role_id); 
        
            $users = User::role($role->name)->get();

            // Detach the role from the users
            foreach ($users as $user) {
                $user->removeRole($role);
            }
            // Delete the role
            $role->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => 1,
                'msg' => trans('message.role-deleted-successfully')
            ]);
           
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error("Error: Deleting Role - ".$e->getMessage());
            
            return response()->json([
                'status' => 0, 
                'msg' => trans('message.something-went-wrong')
            ]); 
        }
    }



}
