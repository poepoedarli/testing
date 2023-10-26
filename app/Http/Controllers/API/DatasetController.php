<?php

namespace App\Http\Controllers\API;

use App\Models\Dataset;
use App\Models\RawData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DatasetController extends BaseController
{

    public function insertImg(Request $request)
    {
        $data = $request->input();
        Log::channel('db')->info('insert dataset img', $data);
        $datasetId = $data['datasetId'];
        $paths = $data['imgPaths'];
        $rawDataArr = [];
        $nowTime = Carbon::now()->timezone('Asia/Singapore');
        foreach ($paths as $value) {
            $lastSlashPos = strrpos($value, '/');
            $substring = substr($value, $lastSlashPos + 1);
            $refNo = strstr($substring, '.', true);
            $rawData['dataset_id'] = $datasetId;
            $rawData['ref_no'] = $refNo;
            $rawData['path'] = $value;
            $rawData['created_at'] = $nowTime;
            $rawDataArr[] = $rawData;
        }
        RawData::insert($rawDataArr);
        Dataset::where('id', $datasetId)->update(['status' => 1]);
        return $this->sendResponse([], 'success');
    }

    public function list()
    {
        $list = Dataset::select("id", "path")->where('status', 3)->get();
        return $this->sendResponse($list, 'success');
    }


}