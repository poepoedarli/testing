<?php

namespace App\Http\Controllers\API;

use App\Models\Dataset;
use App\Models\MlopsInspAi;
use App\Models\MlopsInspManual;
use App\Models\DataSetJobs;
use App\Models\ApplicationVersion;
use App\Models\RunMlopsReport;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MlopsReportController extends BaseController
{
    public function dateSetResult(Request $request)
    {
        $data = $request->input();
        Log::channel('db')->info('Mlops DateSetResult', $data);
        $dataSetId = $data['dataSetId'];
        $jobId = $data['jobId'];
        $serviceRefNo = $data['serviceRefNo'];
        $imgResult = $data['imgResult'];
        $operationMode = $data['operationMode'];
        $rawDataId = $data['rawDataId'];
        $manualInsertData = [];
        $aiInsertData = [];

        $dataSetInfo = Dataset::where('id', $dataSetId)->first();
        $serviceVersionInfo = ApplicationVersion::where('ref_no', $serviceRefNo)->first();
        if (empty($dataSetInfo) || empty($serviceVersionInfo)) {
            Log::channel('db')->error('Mlops insert dateSetResult : data does not exist', $data);
            return $this->sendError("data does not exist");
        }
        //Query whether this image has been manually reviewed based on the dataSetId
        $manualResult = MlopsInspManual::where('data_set_id', $dataSetId)->where('raw_data_id', $rawDataId)->get();
        $isEmptyManualResult = true;
        if (!$manualResult->isEmpty()) {
            $isEmptyManualResult = false;
            $manualResult = $manualResult->toArray();
            $manualResult = array_column($manualResult, null, "part_ref_no");
        }

        foreach ($imgResult as $key => $value) {
            $partRefNo = $dataSetInfo->ref_no . '_' . ($key + 1);
            $aiInfo['data_set_id'] = $dataSetId;
            $aiInfo['job_id'] = $jobId;
            $aiInfo['service_version_id'] = $serviceVersionInfo->id;
            $aiInfo['path'] = $value['path'];
            $aiInfo['ai_result'] = $value['result'];
            $aiInfo['ai_code'] = $value['code'];
            $aiInfo['part_ref_no'] = $partRefNo;
            if (!$isEmptyManualResult) {
                $aiInfo['manual_result'] = $manualResult[$partRefNo]['result'] ?? '';
                $aiInfo['manual_code'] = $manualResult[$partRefNo]['code'] ?? '';
            }
            $aiInfo['created_at'] = Carbon::now()->timezone('Asia/Singapore');
            $aiInfo['raw_data_id'] = $rawDataId;
            $aiInsertData[] = $aiInfo;

            if ($isEmptyManualResult) {
                $manualInfo['data_set_id'] = $dataSetId;
                $manualInfo['service_version_id'] = $serviceVersionInfo->id;
                $manualInfo['path'] = $value['path'];
                $manualInfo['result'] = $value['result'];
                $manualInfo['code'] = $value['code'];
                $manualInfo['part_ref_no'] = $partRefNo;
                $manualInfo['created_at'] = Carbon::now()->timezone('Asia/Singapore');
                $manualInfo['raw_data_id'] = $rawDataId;
                $manualInfo['status'] = 1;//ai judgement
                $manualInsertData[] = $manualInfo;
            }
        }

        try {
            DB::beginTransaction();
            if ($operationMode == 1) {
                //  Batch Insert insp_ai
                MlopsInspAi::insert($aiInsertData);
                //  Batch Insert insp_manual
                if (!empty($manualInsertData)) {
                    MlopsInspManual::insert($manualInsertData);
                }
            } else {
                foreach ($aiInsertData as $key => $v) {
                    unset($aiInsertData[$key]['manual_result']);
                    unset($aiInsertData[$key]['manual_code']);
                }
                RunMlopsReport::insert($aiInsertData);
            }
            //Modify job status
            DataSetJobs::where('id', $jobId)->update(['status' => 2, 'end_time' => Carbon::now()->timezone('Asia/Singapore')]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::channel('db')->error('Mlops insert dateSetResult', [$e->getMessage()]);
            return $this->sendError($e->getMessage());
        }
        return $this->sendResponse([], 'success');
    }

}