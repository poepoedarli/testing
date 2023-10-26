<?php

namespace App\Http\Controllers;

use App\Models\ApplicationResources;
use Illuminate\Http\Request;
use DB;
use Hash;
use DataTables;

class SeviceResoursController extends Controller
{

    public function list(Request $request)
    {
        $serviceVersionId = $request->input('serviceVersionId');
        if ($request->ajax()) {
            $serviceVersionId = $request->input('serviceVersionId');
            $previousTwelfthHour = date('Y-m-d H:00:00', strtotime('-12 hours'));
            $list = ApplicationResources::select("*")->where('log_at', '>=', $previousTwelfthHour)
                ->where('service_version_id', $serviceVersionId)->get();

            $result = [
                'cpu' => [],
                'gpu' => [],
                'memory' => [],
                'logAt' => [],
            ];
            if (!$list->isEmpty()) {
                $result['cpu'] = $list->pluck('cpu_usage')->toArray();
                $result['gpu'] = $list->pluck('gpu_usage')->toArray();
                $result['memory'] = $list->pluck('memory_usage')->toArray();
                $result['logAt'] = $list->pluck('log_at')->toArray();
            }
            return $result;
        } else {
            return view('service.mlops.testingTool.dataSet', compact('serviceVersionId'));
        }

    }
}