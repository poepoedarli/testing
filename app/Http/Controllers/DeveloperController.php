<?php

namespace App\Http\Controllers;

use App\Models\DocCategory;
use App\Models\ApplicationVersion;
use DB;
use Hash;
use DataTables;
use Illuminate\Support\Facades\Auth;


class DeveloperController extends Controller
{

    public function index()
    {
        $list = DocCategory::with('contents')->get();
        return view("developer.documentation", compact('list'));
    }

    public function examples()
    {
        return view("developer.examples");
    }

    public function testTools()
    {
        return view("developer.testTools");
    }

    public function sandbox()
    {
        $data = ApplicationVersion::with("service")->select('*')->where('deleted_at', null)->get();
        return view("developer.sandbox", compact('data'));
    }

    public function deploy()
    {
        return view("developer.deploy");
    }

    public function download()
    {
        $filePath = storage_path('app/public/developer/ocr.iwt');
        return response()->download($filePath);
    }

}