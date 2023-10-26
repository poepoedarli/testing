<?php

namespace App\Http\Controllers\Custom;

use App\Builder\FormControls;
use App\Builder\Template;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationTask;
use App\Models\BackendJob;
use App\Models\Custom\AdcPcbReference;
use App\Models\Custom\AdcPcbResult;
use App\Models\Dataset;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdcPcbController extends Controller
{
    public function tasks(HttpRequest $request, string $id)
    {
        $application = Application::find($id);
        if (is_null($application)) {
            return redirect()->route('applications.index');
        }
        if ($request->ajax()) {
            $data = ApplicationTask::with('dataset', 'application')->select('*');
            return DataTables::of($data)
                ->editColumn('dataset_template_data', function ($row) {
                    $field = '';
                    Log::info($row->dataset_template_data);
                    if (!is_null($row->dataset_template_data)) {
                        foreach (json_decode($row->dataset_template_data) as $key => $value) {
                            $field .= "<span>$key: $value</span>";
                        }
                    } else {
                        $field = '-';
                    }
                    return $field;
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->completed ? $row->updated_at : null;
                })
                ->addColumn('name', function ($row) {
                    return $row->dataset->name;
                })
                ->addColumn('actions', function ($row) {
                    $buttons = "";
                    // show when ai has returned result
                    if ($row->completed) {
                        $buttons .= FormControls::anchor_control(route('adc_pcb.manual_labelling', [$row->application->id, $row->id]), 'Manual Labelling', 'btn btn-sm btn-secondary me-1', 'fa-edit');
                        // show after manual labelling is done
                        $buttons .= FormControls::anchor_control(route('adc_pcb.report', [$row->application->id, $row->id]), 'Report', 'btn btn-sm btn-secondary me-1', 'fa-clipboard');
                    }
                    return $buttons;
                })->rawColumns(['actions', 'dataset_template_data'])->make(true);
        } else {
            $page = "tasks"; // blade file in views
            $parameters = null;
            return view('applications.management.operations', compact('application', 'page', 'parameters'));
        }
    }

    public function results(HttpRequest $request, string $id, string $ref_id)
    {
        $application = Application::find($id);
        if (is_null($application)) {
            return redirect()->route('applications.index');
        }
        if ($request->ajax()) {
            $data = AdcPcbResult::where('ref_id', $ref_id)->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $src = config('global.FILE_SERVER_DOMAIN') . $row->img_path . config('global.FILE_SERVER_SECRET_KEY');
                    return "<img src='$src' as='image' rel='preload' loading='lazy' width='100' class='dt-img' data-id='" . $row->id . "' style='cursor:pointer' />";
                })
                ->rawColumns(['image'])->make(true);
        }
    }
    public function new_task(HttpRequest $request, string $id)
    {
        $application = Application::find($id);
        if (is_null($application)) {
            return redirect()->route('applications.index');
        }
        $page = "new_task"; // blade file in views

        $datasets = Dataset::pluck('name', 'id');
        $datasets_control = FormControls::grid_col(
            12,
            FormControls::select_control('dataset_id', $datasets, null, ['id' => 'dataset_id', 'required' => true], ['text' => 'Select Dataset'])
        );
        $form_controls = Template::convert_template_to_controls($application->dataset_template->template_data);

        $parameters = compact('form_controls', 'datasets', 'datasets_control');

        return view('applications.management.operations', compact('application', 'page', 'parameters'));
    }
    public function store_new_task(HttpRequest $request, string $id)
    {
        $validation_rules = [
            'dataset_id' => 'required',
        ];
        $validated_data = $this->validate($request, $validation_rules);
        $dataset_id = $validated_data["dataset_id"];

        $input = $request->all();

        unset($input["_token"]);
        unset($input["dataset_id"]);

        $validated_template_data = $this->validate($request, $validation_rules);
        $application = Application::find($id);

        // validate dataset template data
        // $validator = Validator::make(
        //     ['name' => null],
        //     ['name' => 'required']
        // );
        // if($validator->fails()){
        //     return redirect()->back()->withInput()->withErrors($validator->errors());
        // }

        // handle dataset template data
        $dataset_template_data = count($input) ? json_encode($input) : null;

        $application_task = ApplicationTask::create([
            'application_id' => $id,
            'dataset_id' => $dataset_id,
            'dataset_template_data' => $dataset_template_data,
        ]);

        // Setup payload for Job
        $payload = [
            'application_id' => $application->id,
            'taskId' => $application_task->id,
            'data' => [
                'data_path' => $application_task->dataset->data_path
            ]
        ];

        $dataset_template_data = json_decode($application_task->dataset_template_data, true);
        if (!is_null($dataset_template_data)) {
            foreach ($dataset_template_data as $k => $v) {
                $payload['data'][$k] = $v;
            }
        }

        BackendJob::create([
            'action_name' => 'new_task',
            'application_id' => $application->id,
            'payload' => json_encode($payload),
            'user_id' => Auth()->user()->id
        ]);

        $application_task->created_by = Auth()->user()->email;
        Log::channel('db')->info('New Task', [$application_task]);

        return redirect()->route('adc_pcb.tasks', $id)->with('success', 'Task created successfully');
    }
    public function manual_labelling(HttpRequest $request, string $id, string $task_id, string $ref_id = null)
    {
        $application = Application::find($id);
        if (is_null($application)) {
            return redirect()->route('applications.index');
        }
        if (is_null($ref_id)) {
            $ref_id = AdcPcbReference::where('task_id', $task_id)->select('id')->orderBy('id', 'asc')->first()->id;
            return redirect()->route('adc_pcb.manual_labelling', [$id, $task_id, $ref_id]);
        }
        $application = Application::find($id);
        $page = "manual_labelling"; // blade file in views
        $task = ApplicationTask::with('dataset')->find($task_id);

        $references = AdcPcbReference::where('task_id', $task_id)->orderBy('id', 'asc')->pluck('id')->toArray();
        $index = array_search($ref_id, $references);
        if ($index === false) {
            return redirect()->route('adc_pcb.tasks', [$id]);
        }

        $next_id = ($index == count($references) - 1) ? null : $references[$index + 1];
        $prev_id = ($index == 0) ? null : $references[$index - 1];

        $reference = AdcPcbReference::with(['results'])->find($ref_id);
        $parameters = compact('task', 'reference', 'next_id', 'prev_id');
        return view('applications.management.operations', compact('application', 'page', 'parameters'));
    }

    public function update_manual_labelling(HttpRequest $request, string $id, string $task_id, string $ref_id)
    {
        $validation_rules = [
            'id' => 'required|exists:adc_pcb_results,id',
            'result' => 'required|in:G,NG',
            'code' => 'nullable',
            'remarks' => 'nullable',
        ];

        // $validated_data = $this->validate($request, $validation_rules);
        $data = $request->all();
        $validator = Validator::make($data, $validation_rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()], 400);
        }

        DB::beginTransaction();
        try {
            $result = AdcPcbResult::find($data['id']);
            $result->update([
                'label_result' => $data['result'],
                'label_code' => $data['code'],
                'remarks' => $data['remarks'],
            ]);
            DB::commit();
            Log::info("AdcPcb Result Updated");
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['success' => false, 'data' => $ex->getMessage()], 400);
        }
        $result->modified_by = Auth()->user()->email;
        Log::channel('db')->info('AdcPcb Result Updated', [$result]);
        return response()->json(['success' => true, 'result' => $result], 200);
    }

    public function report(HttpRequest $request, string $id, string $task_id)
    {
        $application = Application::find($id);
        if (is_null($application)) {
            return redirect()->route('applications.index');
        }
        $page = "report"; // blade file in views
        $task = ApplicationTask::with('dataset')->find($task_id);

        $references = AdcPcbReference::with('results')->select('*')->where('task_id', $task_id)->get();

        $total_tp = $total_fp = $total_tn = $total_fn = $total_results = 0;

        foreach ($references as $key => $ref) {
            $tp = $ref->tpNum();
            $fp = $ref->fpNum();
            $tn = $ref->tnNum();
            $fn = $ref->fnNum();
            $total = count($ref->results) ?? 1;

            $total_tp += $tp;
            $total_fp += $fp;
            $total_tn += $tn;
            $total_fn += $fn;
            $total_results += $total;

            $ref->tp = round($tp / $total * 100, 2);
            $ref->fp = round($fp / $total * 100, 2);
            $ref->tn = round($tn / $total * 100, 2);
            $ref->fn = round($fn / $total * 100, 2);
            $ref->nil = 0 + $total - $tp - $fp - $tn - $fn;
        }

        $report = [
            'tp' => $total_tp,
            'fp' => $total_fp,
            'tn' => $total_tn,
            'fn' => $total_fn,
            'total_results' => $total_results,
            'total_references' => count($references),
            'nil' => $total_results - $total_tp - $total_fp - $total_tn - $total_fn
        ];

        $parameters = compact('task', 'report', 'references');
        return view('applications.management.operations', compact('application', 'page', 'parameters'));
    }
}