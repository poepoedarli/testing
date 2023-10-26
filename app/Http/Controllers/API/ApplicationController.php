<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Application;
use App\Models\ApplicationResourcesUsage;
use Validator;
use Log;
use App\Events\ApplicationStateChanged;
use App\Events\ApplicationResourcesUpdated;
class ApplicationController extends BaseController
{
    public function getApplications($state=null)
    {
        $data = [];
        $applications = Application::where('is_cloned', true);
        if(!is_null($state)) {
            $applications->where('state', $state);
        }
        $applications = $applications->orderBy('name', 'asc')->get();
        $data['applications'] = $applications->toArray();

        return $this->sendResponse($data, 'Applications retrieved successfully.');
    }

    public function updateState(Request $request){
        $data = $request->input();
        $validator = Validator::make($data, [
            'application_id' => 'required',
            'state' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }

        
        $application_id = $data['application_id'];
        $state = $data['state'];
        $message = isset($data['message']) ? $data['message'] : '';
        
        $app = Application::where('id', $application_id)->first();
        $app->update([
            'state' => $state,
            'under_state_changing' => ''
        ]);
        
        event(new ApplicationStateChanged($application_id, $state));

        Log::channel('db')->debug('API: update application state ', $data);
        return $this->sendResponse($data, 'Applications State updated successfully.');
    }

    public function updateResourcesUsage(Request $request) {
        $data = $request->input();
        $validator = Validator::make($data, [
            'application_id' => 'required',
            'cpu_usage' => 'required',
            'gpu_usage' => 'required',
            'memory_usage' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }
        
        $application_id = $data['application_id'];
        $cpu_usage = $data['cpu_usage'];
        $gpu_usage = $data['gpu_usage'];
        $memory_usage = $data['memory_usage'];
        
        
        $app = ApplicationResourcesUsage::updateOrCreate(
            ['application_id' => $application_id],
            [
                'cpu_usage' => $cpu_usage,
                'gpu_usage' => $gpu_usage,
                'memory_usage' => $memory_usage
            ]
        );

        event(new ApplicationResourcesUpdated($application_id));

        Log::channel('db')->debug('API: update application resources usage ', $data);
        return $this->sendResponse($app, 'Applications Resources usage updated successfully.');
    }

}