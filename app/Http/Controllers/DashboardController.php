<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  
use App\Models\Section;
use App\Models\Section18HearingDetail;
use App\Models\MasterProject;
use App\Models\MasterCourt;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\MasterDivision;
use App\Models\MasterCircle;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view("dashboard");
    }  
}
