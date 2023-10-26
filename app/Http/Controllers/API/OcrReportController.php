<?php

namespace App\Http\Controllers\API;

use App\Models\Dataset;
use App\Models\MlopsInspAi;
use App\Models\MlopsInspManual;
use App\Models\DataSetJobs;
use App\Models\OcrReport;
use App\Models\ApplicationVersion;
use App\Models\RunOcrReport;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OcrReportController extends BaseController
{
    public function store(Request $request)
    {
        $data = $request->input();
        Log::channel('db')->info('Insert Ocr Result', $data);
        $dataSetId = $data['dataSetId'];
        $jobId = $data['jobId'];
        $serviceRefNo = $data['serviceRefNo'];
        $result = $data['result'];
        $operationMode = $data['operationMode'];
        $rawDataId = $data['rawDataId'];


        $dataSetInfo = Dataset::where('id', $dataSetId)->first();
        $serviceVersionInfo = ApplicationVersion::where('ref_no', $serviceRefNo)->first();
        if (empty($dataSetInfo) || empty($serviceVersionInfo)) {
            Log::channel('db')->error('Insert Ocr Result : data does not exist', $data);
            return $this->sendError("data does not exist");
        }

        try {
            DB::beginTransaction();
            $insertData['job_id'] = $jobId;
            $insertData['data_set_id'] = $dataSetId;
            $insertData['service_version_id'] = $serviceVersionInfo->id;
            $insertData['result'] = $result;
            $insertData['status'] = 1;
            $insertData['raw_data_id'] = $rawDataId;
            if ($operationMode == 1) {
                OcrReport::create($insertData);
            } else {
                RunOcrReport::create($insertData);
            }
            //Modify job status
            DataSetJobs::where('id', $jobId)->update(['status' => 2, 'end_time' => Carbon::now()->timezone('Asia/Singapore')]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::channel('db')->error('Insert Ocr Result', [$e->getMessage()]);
            return $this->sendError($e->getMessage());
        }
        return $this->sendResponse([], 'success');
    }

}