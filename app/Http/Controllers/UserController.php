<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Core;
use Log;
use DataTables;
use Illuminate\Support\Facades\Auth;  
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Jobs\SendEmailJob;


class UserController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:user-access', ['only' => ['index','getUserData']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-status', ['only' => ['changeStatus']]);
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }
        return view('user.user_list');
    }

    public function getUserData(Request $request)
    {
        if ($request->ajax()) { 
          
            $user = Auth::user();
            $users = User::with('roles')->get();          
            
            return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('role', function($row){    
                return $row->roles[0]->name;
            })
            ->addColumn('status', function($row){    
                if($row->status == '1'){
                    $statusBtn =  trans('lables.active'); //'<span class="badge badge-success">Active</span>';
                } else if($row->status == '0') {
                    $statusBtn = trans('lables.deactive'); //'<span class="badge badge-danger">Inactive</span>';
                }
                return $statusBtn;
            })
            ->addColumn('action', function($row){    
               
                $editBtn = '';
                $editBtn .= '<a class=" action_btn btn btn-sm bg-indigo rounded-circle p-2 round_btn" target="_self" id="edit_user_btn" href="'.route("user_edit",[$row->id]).'"><i class="fas fa-pencil-alt"></i></a>';
                
                $deleteBtn = '';
                
                $deleteBtn .= '<button type="button"  class="action_btn btn btn-sm btn-danger round_btn rounded-circle p-2 delete_user_btn" value="'.$row->id.'"  ><i class="fas fa-trash-alt"></i></button>';
                
                $actionBtn = '<ul class="listing line"> <li>'.$editBtn.'</li> <li class="mr-2 ml-2">'.$deleteBtn.'</li></ul>';
                return $actionBtn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function create()
    {
        $user = Auth::user();      
        $data['roles']  = Role::where('guard_name','=','web')->where('name','!=','Admin')->get();
        return view('user.user_add',$data);
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
            'name' => 'required|string|max:50|regex:/^[a-zA-Z .]+$/',
            'email' => 'required|max:100|email:rfc,dns|unique:users',
            'mobile_no' => 'required|digits:10|numeric',
            'user_name' => 'required|unique:users',
            'password' => ['required','regex:/(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*._])(?=.*[A-Z]){8,15}/','confirmed'],
            'password_confirmation' => 'required|same:password',
            'roles' => 'required|integer',
        ],[
            'name.required' => 'Name cannot be empty',
            'name.max' => 'Name cannot be longer than 50 characters',
            'name.regex' =>'Name must contain only characters',

            'email.required' =>'Email Id cannot be empty',
            'email.email' => 'Email Id is not valid',
            'email.unique'=> 'The entered email id already exists',

            'mobile_no.required' => 'Mobile number cannot be empty',
            'mobile_no.numeric' => 'Mobile number must be numeric',
            'mobile_no.digits' => 'Mobile number must be only of 10 digits',

            'user_name.required' => 'Useraname cannot be empty',
            'user_name.unique'=> 'The entered username already exists',

            'password.required' => 'Password cannot be empty',
            'password_confirmation.required' => 'Password confirmation cannot be empty',
            'password.min' =>'Password must be at least 8 characters',
            'password.regex' => 'Passwords must contain at least eight characters, including uppercase, lowercase, special letters and numbers',
            'password.confirmed' => 'Password is not matching with cofirm password',
            'password_confirmation.same' =>  'Password confirmation must match with password field',  
            
            'roles.required' => 'Role field cannot be empty',
        ]);

        try{
            // Create New User
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->user_name = $request->user_name;
            $user->password = Hash::make($request->password);
            $user->flag = "admin_user";  
            $user->last_login_at = Carbon::now();
            $user->last_login_ip = '127.0.0.1';
            $user->save();

            if ($request->roles) {
                $user->syncRoles($request->roles);
            }
          
            try {
                $user_roles = $user->getRoleNames();        
                
                $subject = "User Registration";
                $content = "<p>Dear ".$request->name.",</p>
                <p>Welcome !</p>
                <h5>Registration details as below:</h5>
                <p> Email : ".$request->email."</p>
                <p> Username : ".$request->user_name."</p>
                <p> Password : ".$request->password." </p>
                <p> Role Assign is : ".$userRole[0]."</p>
                <p>Please find your login credentials to login to application </p>";

                // Dispatch the job to the queue
                SendEmailJob::dispatch('customeEmail',$request->email,$subject, 'emails.custom_email', $content);

                
            } catch (\Exception $e) {
                // Handle the exception
                Log::info("Error : sending User Registration email:".$e);
            }

            return redirect()->route('user')->with('success', trans('message.user-added-successfully'));
        }catch(\Exception $e){
            Log::info("Error : add user ".$e);
            return redirect()->route('user_create')->with("error",trans('message.something-went-wrong'));
        }
    }

    public function edit($id)
    {
        $userData = User::with('roles')->where('id','=',$id)->first();
        if(!$userData){  
            return redirect()->route('user')->with("error", trans('message.something-went-wrong'));      
        } 

        $data['userData'] = $userData;

        $data['roles']  = Role::where('guard_name','=','web')->where('name','!=','Admin')->get();
        return view('user.user_edit',$data);
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
        $rowid = $request->id;
        $roles = $request->input('roles');

        $request->validate([
            'name' => 'required|string|max:50|regex:/^[a-zA-Z .]+$/',
            'email' => 'required|max:100|email|unique:users,email,'.$rowid,
            'mobile_no' => 'required|digits:10|numeric',
            'user_name' => 'required|unique:users,user_name,'.$rowid,
            'password' => ['nullable','regex:/(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*._])(?=.*[A-Z]){8,15}/','confirmed'],
            'password_confirmation' => 'nullable|same:password',
            'roles' => 'required|integer',
        ],[
            'name.required' => 'Name cannot be empty',
            'name.max' => 'Name cannot be longer than 50 characters',
            'name.regex' =>'Name must contain only characters',

            'email.required' =>'Email Id cannot be empty',
            'email.email' => 'Email Id is not valid',
            'email.unique'=> 'The entered email id already exists',

            'mobile_no.required' => 'Mobile number cannot be empty',
            'mobile_no.numeric' => 'Mobile number must be numeric',
            'mobile_no.digits' => 'Mobile number must be only of 10 digits',

            'user_name.required' => 'Useraname cannot be empty',
            'user_name.unique'=> 'The entered username already exists',

            'password.required' => 'Password cannot be empty',
            'password_confirmation.required' => 'Password confirmation cannot be empty',
            'password.min' =>'Password must be at least 8 characters',
            'password.regex' => 'Passwords must contain at least eight characters, including uppercase, lowercase, special letters and numbers',
            'password.confirmed' => 'Password is not matching with cofirm password',
            'password_confirmation.same' =>  'Password confirmation must match with password field',  
            
            'roles.required' => 'Role field cannot be empty',
        ]);

        try{
            $user =  User::find($rowid);
            if(!$user) {
                return redirect()->route('user_edit',[$request->id])->with("error",trans('message.something-went-wrong'));  
            } 

            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->user_name = $request->user_name;
            if(!empty($request->password)){ 
                $user->password = Hash::make($request->password);
            }
            $user->updated_at = Carbon::now();
            $user->save();

            if ($request->roles) {
                $user->syncRoles($request->roles);
            }
            return redirect()->route('user')->with('success',trans('message.user-updated-successfully'));
            
        }catch(\Exception $e){
            Log::info("Error : update user ".$e);
            return redirect()->route('user_edit',[$request->id])->with("error",trans('message.something-went-wrong'));
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
        try {
            $id = $request->id;
            $user =  User::find($id);
            $user->delete();
                
            return response()->json([
                'success' => 1,
                'msg' => trans('message.user-deleted-successfully')
            ]);

        }catch(\Exception $e) {
            Log::error("Error: Deleting user - ".$e);
            return response()->json([
                'status' => 0, 
                'msg' => trans('message.something-went-wrong')
            ]); 
        }
    }    
    
    public function changeStatus(Request $request)
    {
        try {
            $id = $request->id;
            $status = $request->status;
            $user =  User::find($id);

            $user->status = $status;
            $user->save();

            return response()->json([
                'success' => 1,
                'msg' => trans('message.user-status-changed-successfully') 
            ]);

        }catch(\Exception $e) {
            Log::error("Error: change user status - ".$e);
            return response()->json([
                'status' => 0, 
                'msg' => trans('message.something-went-wrong')
            ]); 
        }
    }
    
}

