<?php

namespace App\Http\Controllers;

use App\Builder\FormControls;
use App\Models\Application;
use App\Models\Service;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MyAppController extends Controller
{
    public function index()
    {
        // show only cloned applications
        $services = Service::select('*')->orderBy('id', 'desc')->get();
        $applications = Application::select('*')->where('is_cloned', true)->where('status', true)->orderBy('id', 'desc')->get();
        return view('myapps.index', compact('services', 'applications'));
    }

    
}