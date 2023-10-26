<?php

namespace App\Http\Controllers;

use App\Models\DataSetTraining;
use App\Models\Application;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use DB;
use Hash;
use DataTables;

class DataSetTrainingController extends Controller
{
   

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DataSetTraining::with("serviceVersion")->select("*")->get();
            foreach ($data as $key => $value) {
                $serviceInfo = [];
                if ($value['serviceVersion']) {
                    $serviceInfo = Application::where('id', $value['serviceVersion']['service_id'])->first();
                }
                $data[$key]['service'] = $serviceInfo;
            }
            return Datatables::of($data)
                ->editColumn('status', function ($row) {
                    return match ($row->status) {
                        "1" => "under training",
                        "2" => "done",
                    };
                })->editColumn('data_set_ids', function ($row) {
                    return implode(',', json_decode($row['data_set_ids']));
                })
                ->addColumn('serviceName', function ($row) {
                    $serviceName = '';
                    if ($row['serviceVersion']) {
                        $serviceName = $row['service']['name'] . $row['serviceVersion']['version'];
                    }
                    return $serviceName;
                })
                ->make();
        } else {
            return view('dataSetTraining.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function store(Request $request): void
    {
        $validation_rules = [
            'dataSetIds' => 'required|array|min:1',
        ];
        $this->validate($request, $validation_rules);
        $insertData['data_set_ids'] = json_encode($request->input('dataSetIds'));
        $insertData['user_id'] = Auth::user()->id;
        $insertData['start_time'] = Carbon::now()->timezone('Asia/Singapore');;
        $insertData['status'] = 1;
        $info = DataSetTraining::create($insertData);
        //Logging
        $info->created_by = Auth::user()->email;
        Log::channel('db')->info('Created DataSetTraining', [$info]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $dataSet = DataSetTraining::find($id);
        $dataSet->update(['status' => 2]);
        $dataSet->deleted_by = Auth::user()->email;
        Log::channel('db')->info('Deleted dataSet', [$dataSet]);
        return response()->json(['status' => 'success', 'message' => "Dataset deleted successfully"], 200);
    }

}