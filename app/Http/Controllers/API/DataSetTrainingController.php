<?php

namespace App\Http\Controllers\API;


use App\Models\Dataset;
use App\Models\DataSetTraining;


class DataSetTrainingController extends BaseController
{
    public function list()
    {
        $list = DataSetTraining::select("*")->where('status', 1)->get();
        if ($list->isEmpty()) {
            return $this->sendResponse([], 'success');
        }
        $result = [];
        foreach ($list as $value) {
            $info = [];
            $info['id'] = (string)$value['id'];
            $dataSetIds = json_decode($value['data_set_ids']);
            $dataSets = Dataset::whereIn('id', $dataSetIds)->pluck('path')->toArray();;
            $info['imgPath'] = $dataSets;
            $result[] = $info;
        }
        return $this->sendResponse($result, 'success');
    }
}