<?php

namespace App\Http\Controllers\API\Custom;

use App\Http\Controllers\API\BaseController;
use App\Models\ApplicationTask;
use App\Models\Custom\AdcPcbReference;
use App\Models\Custom\AdcPcbResult;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdcPcbController extends BaseController
{
    public function createReference(HttpRequest $request)
    {
        /**
         * taskId, imgPaths
         */
        $data = $request->all();
        $validator = Validator::make($data, [
            'taskId' => 'required|exists:application_tasks,id',
            'imgPaths' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            Log::channel('db')->error('ADC PCB API createReference, Validation Failed.', [$validator->errors()]);
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $task_id = $data['taskId'];
        $img_paths = $data['imgPaths'];

        $refs = [];
        foreach ($img_paths as $img_path) {
            $img_name = strstr(substr($img_path, strrpos($img_path, '/') + 1), '.', true);
            $refs[] = [
                'task_id' => $task_id,
                'img_path' => $img_path,
                'img_name' => $img_name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::beginTransaction();
        try {
            $count = AdcPcbReference::where('task_id', $task_id)->count('id');
            if ($count > 0) {
                throw new Exception("Task already have reference");
            }

            $inserted = AdcPcbReference::insert($refs);
            DB::commit();
            if ($inserted) {
                Log::info(count($refs) . " rows inserted adc_pcb_reference");
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::channel('db')->error('Error creating ADC PCB References', [$e->getMessage()]);
            return $this->sendError($e->getMessage());
        }
        Log::channel('db')->info('ADC PCB References created successfully', [$refs]);
        return $this->sendResponse([], 'success');
    }
    public function getReferences(HttpRequest $request)
    {
        $references = AdcPcbReference::select(['id as refId', 'img_path as imgPath'])->where('processed', false)->get();
        return $this->sendResponse($references, 'success');
    }
    public function createResults(HttpRequest $request)
    {
        Log::info('createResults');
        /**
         * taskId, refId, results
         */
        $data = $request->all();
        $validator = Validator::make($data, [
            'taskId' => 'required|exists:application_tasks,id',
            'refId' => 'required|exists:adc_pcb_references,id',
            'imgResult' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            Log::channel('db')->error('ADC PCB API createResults, Validation Failed.', [$validator->errors()]);
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $messages = [];
        $task_id = $data['taskId'];
        $ref_id = $data['refId'];
        $img_result = $data['imgResult'];

        DB::beginTransaction();
        try {
            $task = ApplicationTask::find($task_id);
            if ($task->completed) {
                throw new Exception("Task already completed");
            }

            $reference = AdcPcbReference::find($ref_id);
            if ($reference->processed) {
                throw new Exception("Reference already processed");
            }

            // Insert Result, Update Reference
            $results = [];
            foreach ($img_result as $value) {
                $result = [
                    'ref_id' => $ref_id,
                    'img_path' => $value['path'],
                    'ai_result' => $value['result'],
                    'ai_code' => $value['code'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
                $results[] = $result;
            }
            $inserted = AdcPcbResult::insert($results);
            $updated = $reference->update(['processed' => true]);
            DB::commit();
            if ($inserted) {
                Log::info(count($results) . " rows inserted adc_pcb_results");
                $messages[] = "Results created successfully";
            }
            if ($updated) {
                Log::info("1 row updated adc_pcb_reference");
                $messages[] = "Reference updated successfully";
            }

            // Check if all reference are processed, Update task
            $task_updated = false;
            $unprocessed = AdcPcbReference::where('processed', false)->count('id');
            if ($unprocessed <= 0) {
                $task_updated = $task->update([
                    'end_time' => Carbon::now(),
                    'completed' => true,
                ]);
                Log::info("$task_updated");
            }
            DB::commit();
            if ($task_updated) {
                Log::info("1 row updated application_tasks");
                $messages[] = "Task updated successfully";
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::channel('db')->error('An Error Occured ADC PCB Task', [$e->getMessage()]);
            return $this->sendError($e->getMessage());
        }


        return $this->sendResponse([], ['success', ...$messages]);
    }
}