<?php

namespace App\Http\Controllers;

use App\Models\ApplicationLog;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Illuminate\Support\Facades\Auth;


class ServiceLogController extends Controller
{

    public function index(Request $request)
    {
        $serviceVersionId = $request->input('serviceVersionId');
        if ($request->ajax()) {
            $data = ApplicationLog::where("service_version_id", $serviceVersionId)->select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('type-badge', function ($row) {
                    $colors = ['INFO' => 'info', 'WARING' => 'warning', 'ERROR' => 'danger'];
                    return "<span style='cursor: default' class='btn btn-sm text-white btn-" . $colors[$row->category] . "'> " . strtoupper($row->category) . "</a> ";
                })
                ->rawColumns(['type-badge'])
                ->make(true);

        } else {
            return view('service.mlops.testingTool.dataSet', compact('serviceVersionId'));
        }
    }
}