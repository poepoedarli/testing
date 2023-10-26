<?php

namespace App\Http\Controllers;

use App\Builder\FormControls;
use App\Models\Dataset;
use App\Models\ApplicationVersion;
use App\Models\RawData;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use DB;
use Hash;
use DataTables;
use Exception;
use Illuminate\Support\Facades\Storage;

class DatasetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|JsonResponse
     */

    public function __construct()
    {
        $this->middleware('permission:dataset-list');
        $this->middleware('permission:dataset-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:dataset-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:dataset-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $currentUser = Auth::user();

        $departmentDatasets = Dataset::whereHas('creator', function ($query) use ($currentUser) {
            $query->where('department_id', $currentUser->department_id);
        })->orderBy('id', 'desc')->get();

        $otherDepartmentDatasets = Dataset::whereHas('creator', function ($query) use ($currentUser) {
            $query->where('department_id', '!=', $currentUser->department_id);
        })->where('is_public', 1)->orderBy('id', 'desc')->get();

        return view('datasets.index', compact('departmentDatasets', 'otherDepartmentDatasets'));
    }

    public function create(Request $request)
    {
        Log::info(

            [

                'disk' => Storage::disk('choco')

            ]

        );
        
        $dataset_types = [];
        $types = config('global.dataset_types');
        foreach ($types as $key => $value) {
            $dataset_types[$value] = $value;
        }
        return view('datasets.create', compact('dataset_types'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validation_rules = [
            'name' => 'required|unique:datasets,name',
        ];

        if (empty($request->file())) { //not uploaded
            $validation_rules['data_path'] = 'required';
        } else { //uploaded
            $validation_rules['local_upload.*'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            $input['data_path'] = '-';
        }

        $this->validate($request, $validation_rules);

        $input['creator_id'] = Auth::user()->id;
        $input['department_id'] = Auth::user()->department_id;
        $input['ref_no'] = uniqid('ImageDS-');
        $dataSet = Dataset::create($input);

        $uploadedImages = $request->file();
        if ($uploadedImages && $uploadedImages['local_upload']) {
            $dir_path = $this->uploadImgtoAzure($uploadedImages['local_upload'], $dataSet);
            $azure_storage_url = config('global.AZURE_STORAGE_URL');
            $dataSet->data_path = $azure_storage_url . '/' . $dir_path;
            $dataSet->save();
        }

        //Logging
        $dataSet->created_by = Auth::user()->email;
        Log::channel('db')->info('Created Dataset', [$dataSet]);

        return redirect()->route('datasets.index')->with('success', 'Dataset created successfully');
    }

    public function show(Request $request, Dataset $dataset)
    {
        return view('datasets.show', compact('dataset'));
    }

    public function edit(Request $request, Dataset $dataset)
    {
        $dataset_types = [];
        $types = config('global.dataset_types');
        foreach ($types as $key => $value) {
            $dataset_types[$value] = $value;
        }
        $filenames = [];
        // $url = "https://wavelengthblob.blob.core.windows.net/dataset?sv=2021-10-04&st=2023-10-10T09%3A20%3A31Z&se=2030-12-14T09%3A20%3A00Z&sr=c&sp=rlf&sig=GsGaXFjxFDC%2FvCYmf9H6dSfGS2TH2%2Fr2FGC6g5QbY6I%3D&restype=container&comp=list&prefix=rawData/29";
        // $url = $dataset->data_path . config('global.FILE_SERVER_SECRET_KEY') . '&restype=directory&comp=list';
        $url = config('global.AZURE_STORAGE_URL') . "/" . config('global.AZURE_BLOB_DATASET_SAS') . "&restype=container&comp=list&prefix=rawData/" . $dataset->id . "/";
        try {
            $xml = simplexml_load_file($url);
            $blobs = json_decode(json_encode($xml->Blobs), true);
            // Log::info([
            //     'url' => $url,
            //     'blobs' => $blobs,
            // ]);
            if (isset($blobs['Blob']) && sizeof($blobs['Blob'])) {
                $filenames = array_column($blobs['Blob'], 'Name');
            }

            // Log::info([
            //     'filenames' => $filenames,
            // ]);
        } catch (Exception $ex) {
            Log::info($ex->getMessage());
        }

        return view('datasets.edit', compact('dataset', 'dataset_types', 'filenames'));
    }

    public function update(Request $request, Dataset $dataset)
    {
        $input = $request->all();
        $validation_rules = [
            'name' => 'required|unique:datasets,name,' . $dataset->id,
            //'data_path' => 'required',
        ];

        if (empty($request->file())) { //not uploaded
            // $validation_rules['data_path'] = 'required';
        } else { //uploaded
            $validation_rules['local_upload.*'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';

        }

        $this->validate($request, $validation_rules);

        $uploadedImages = $request->file();
        if ($uploadedImages && $uploadedImages['local_upload']) {
            $dir_path = $this->uploadImgtoAzure($uploadedImages['local_upload'], $dataset);
            $azure_storage_url = config('global.AZURE_STORAGE_URL');
        }
        if (!isset($input['is_public'])) {
            $input['is_public'] = 0;
        }
        $dataset->update($input);

        //logging
        $dataset->modified_by = Auth::user()->email;
        Log::channel('db')->info('Modified Dataset', [$dataset]);

        return redirect()->route('datasets.index')
            ->with('success', 'Dataset updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dataset $dataset)
    {
        $dataset->deleted_by = Auth::user()->email;
        Log::channel('db')->info('Deleted dataSet', [$dataset]);

        $dataset->delete();

        return redirect()->route('datasets.index')
            ->with('success', 'Dataset deleted successfully');
    }

    private function uploadImgtoAzure($images, $dataset = null)
    {
        $dir_path = 'rawData/' . $dataset->id;
        foreach ($images as $key => $img) {
            try {
                $path =  $img->store($dir_path, 'choco');
                // $path =  $img->storeAs($dir_path, $dataset->id . "-" . $key, 'azure');
                // $path = $img->storeAs("dataset/$dir_path", $dataset->id . "-" . $key . ".jpg", 'azure');

                // $path = Storage::disk('azure')->put($dir_path, $img);
                Log::info([
                    'url' => Storage::url('azure'),
                    '$img' => $img,
                    '$dir_path' => $dir_path,
                    'uploadImgtoAzure path' => $path
                ]);
            } catch (\Exception $e) {
                // Capture the error message if the upload fails
                $errorMessage = $e->getMessage();
                Log::error($errorMessage);
            }
        }
        return $dir_path;
    }

    /*public function getFile($type, $folder = "")
    {
        if ($type == 1) {
            $typeName = "directory";
        } else {
            $typeName = "file";
        }
        $url = env("FILE_SERVER_API") . "api/FileShareInfo/list-" . $typeName . "?directoryPath=temporary/" . $folder;

        $arrayData = [];
        try {
            $response = Http::get($url)->throw();
            if ($response) {
                $arrayData = $response->json();
            }
        } catch (\Throwable $th) {
            Log::channel('db')->warning('Get file list directory', [$th->getMessage(), ['url' => $url]]);
        }
        $result = [];
        if ($arrayData) {
            $result = $arrayData['data'];
        }
        return $result;
    }*/
}