<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Yoeriboven\LaravelLogDb\Models\LogMessage;
use DB;
use DataTables;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function userSettings(Request $request)
    {
        return view('settings.user');
    }

    public function systemSettings(Request $request)
    {
        return view('settings.system');
    }
    
}