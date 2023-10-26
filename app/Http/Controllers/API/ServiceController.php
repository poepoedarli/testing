<?php

namespace App\Http\Controllers\API;


use App\Models\DataSetJobs;
use App\Models\ApplicationLog;
use App\Models\ApplicationResources;
use App\Models\ApplicationVersion;
use App\Models\RawData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServiceController extends BaseController
{

    public function insertLog(Request $request)
    {
        $data = $request->input();
        Log::channel('db')->info('Mlops Log', $data);
        $serviceRefNo = $data['serviceRefNo'];
        $insertData = $data['data'];
        $serviceVersionInfo = ApplicationVersion::where('ref_no', $serviceRefNo)->first();
        if (empty($serviceVersionInfo)) {
            Log::channel('db')->error('Mlops insert dateSetResult : data does not exist', $data);
            return $this->sendError("data does not exist");
        }
        foreach ($insertData as $key => $value) {
            $insertData[$key]['service_version_id'] = $serviceVersionInfo->id;
        }
        ApplicationLog::insert($insertData);

    }

    public function insertResourceUsage(Request $request)
    {
        $data = $request->input();
        Log::channel('db')->info('Mlops Resource Usage', $data);
        $serviceRefNo = $data['serviceRefNo'];
        $insertData = $data['data'];
        $serviceVersionInfo = ApplicationVersion::where('ref_no', $serviceRefNo)->first();
        if (empty($serviceVersionInfo)) {
            Log::channel('db')->error('Mlops insert dateSetResult : data does not exist', $data);
            return $this->sendError("data does not exist");
        }
        foreach ($insertData as $key => $value) {
            $insertData[$key]['service_version_id'] = $serviceVersionInfo->id;
        }
        ApplicationResources::insert($insertData);
    }

    public function getServiceList()
    {
        $list = ApplicationVersion::select("ref_no", "status")->where('deleted_at', null)->get();
        return $this->sendResponse($list, 'success');
    }

    public function getJobList()
    {
        $list = DataSetJobs::with("serviceVersion")->with("dataSet")->select("*")->where('status', 1)->get();
        if ($list->isEmpty()) {
            return $this->sendResponse([], 'success');
        }
        $result = [];
        foreach ($list as $value) {
            $job['datasetId'] = $value['data_set_id'];
            $job['jobId'] = (string)$value['id'];
            $job['serviceRefNo'] = $value['serviceVersion']['ref_no'];
            $job['operationMode'] = $value['operation_mode'];
            $rawData = RawData::where("dataset_id", $value['data_set_id'])->select("id", "path")->get();
            $job['rawData'] = [];
            foreach ($rawData as $v) {
                $info['id'] = strval($v['id']);
                $info['path'] = $v['path'];
                $job['rawData'][] = $info;
            }
            $result[] = $job;
        }
        return $this->sendResponse($result, 'success');
    }
}