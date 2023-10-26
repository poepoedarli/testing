<?php

namespace App\Http\Controllers\API;

use App\Models\ApplicationTask;

class ApplicationTaskController extends BaseController
{
    // Function for all applications outgoing
    public function getTaskList()
    {
        $task_list = [];
        $tasks = ApplicationTask::with('dataset')->where('completed', false)->select('*')->get();
        if ($tasks->isEmpty()) {
            return $this->sendResponse($task_list, 'success');
        }

        foreach ($tasks as $task) {
            $temp = [
                'appId' => $task->application->id,
                'taskId' => $task->id,
            ];
            $temp['data'][] = ['data_path' => $task->dataset->data_path]; //  fixed for now for images dir

            $dataset_template_data = json_decode($task->dataset_template_data, true);
            foreach ($dataset_template_data as $k => $v) {
                $temp['data'][] = [$k => $v];
            }
            $task_list[] = $temp;
        }

        return $this->sendResponse($task_list, 'success');
    }
}