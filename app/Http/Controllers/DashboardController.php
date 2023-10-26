<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:dashboard');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = [];
        $logList = [];
        foreach ($logList as $key => $log) {
            $serviceVersionInfo = ApplicationVersion::with("service")->where('id', $log->service_version_id)->first();
            if (!empty($serviceVersionInfo)) {
                $logList[$key]['serviceName'] = $serviceVersionInfo->service->name . $serviceVersionInfo->version;
            }
        }
        return view('dashboard', compact('data', 'logList'));
    }

    public function central_dashboard(){
        return view('central_dashboard');
    }
}
