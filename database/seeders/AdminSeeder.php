<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('email','admin@gmail.com')->first();

        if (is_null($admin)) {            
            $request = App::make(Request::class);

            
            $admin           = new User();
            $admin->name     = "Administrator";
            $admin->email    = "admin@gmail.com";
            $admin->email_verified_at = Carbon::now();
            $admin->mobile_no = "123456789" ;
            $admin->user_name = 'Admin';
            $admin->password = Hash::make('admin123');
            $admin->save();
        } 
    }
}


