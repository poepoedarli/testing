<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\BackendJob;
use Validator;
use Log;

class BackendJobController extends BaseController
{
    public function list()
    {
        $data = [];
        $jobs = BackendJob::where('mark_as_done', false)->orderBy('id', 'asc')->get();
        $data['jobs'] = $jobs->toArray();

        return $this->sendResponse($data, 'Jobs retrieved successfully.');
    }

    public function markAsDone(Request $request){
        $data = $request->input();
        $validator = Validator::make($data, [
            'id' => 'required', //job's id
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }

        
        $id = $data['id'];
        $job = BackendJob::where('id', $id)->first();
        if(is_null($job)){
            Log::channel('db')->debug('API: Mark Job as Done ', ['Error'=> "This Job_ID $id no exist in our system"]);
            return $this->sendError("This Job_ID = $id no exist in our system");     
        }

        $job->update([
            'mark_as_done' => true
        ]);
        Log::channel('db')->debug('API: Mark Job as Done ', $data);
        return $this->sendResponse($data, 'Job done successfully.');
    }
}
