<?php

namespace App\Http\Controllers;

use App\Builder\FormControls;
use App\Models\Application;
use App\Models\DatasetTemplate;
use App\Models\OperationPage;
use App\Models\Service;
use App\Models\BackendJob;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use File;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:application-list');
        $this->middleware('permission:application-control', ['only' => ['start_application', 'stop_application', 'restart_application']]);
        $this->middleware('permission:application-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:application-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:application-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // show only original applications
        $services = Service::select('*')->orderBy('id', 'desc')->get();
        $applications = Application::select('*')->where('is_cloned', false)->orderBy('id', 'desc')->get();
        return view('applications.index', compact('services', 'applications'));
    }

    public function cloneApplication(Application $application)
    {
        $message = 'Application and Dataset Template cloned successfully';
        $response = [
            'success' => true,
            'message' => $message,
            'data' => []
        ];

        DB::beginTransaction();
        try {
            $newApp = $application->replicate();
            $newApp->status = false;
            $newApp->is_cloned = true;
            $newApp->parent_app_id = $application->id;
            $newApp->created_at = Carbon::now();
            $newApp->save();

            $newDST = DatasetTemplate::create([
                'application_id' => $newApp->id,
                'template_data' => $application->dataset_template->template_data
            ]);

            DB::commit();
            Log::channel('db')->info($message, [$newApp, $newDST]);
            $response['data'] = $newApp;
            return response()->json($response, 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), []);

            $response['success'] = false;
            $response['message'] = $e->getMessage();
            return response()->json($response, 500);
        }
    }

    public function editClonedApplication(Application $application){
        $form_controls = $this->form_controls($application, false, true);
        $is_cloned = true;
        return view('applications.edit', compact('application', 'form_controls', 'is_cloned'));
    }

    public function create($service_id = null)
    {
        $form_controls = $this->form_controls();
        return view('applications.create', compact('form_controls', 'service_id'));
    }

    public function store(HttpRequest $request)
    {
        $validated_data = $this->validate_form_controls($request);
        $screenshots = [];
        
        $uploadedImages = $request->file();
        if($uploadedImages && $uploadedImages['web_page_screenshots']){
            $screenshots = $this->handleImages($uploadedImages['web_page_screenshots']);
        }
        $name = strtolower($validated_data['name']);
        //$folder_name = implode('_',explode(' ',$name));
        $ref_no = implode('-',explode(' ',$name));
        $validated_data['ref_no'] = $ref_no;
        //$validated_data['folder_name'] = $folder_name;
        $validated_data['web_page_screenshots'] = json_encode($screenshots);
        $validated_data['container_info'] = isset($validated_data['container_info'])?json_encode($validated_data['container_info']):null;

        $template_data = [];
        if(isset( $validated_data['fields'])){
            $template_data = $validated_data['fields'];
            unset($validated_data['fields']);
        }
        $validated_data['creator_id'] = Auth()->user()->id;

        DB::beginTransaction();
        try {
            $application = Application::create($validated_data);
            $dataset_template = DatasetTemplate::create([
                'application_id' => $application->id,
                'template_data' => json_encode($template_data)
            ]);
            DB::commit();

            //create folder and blade for new app's design flows
            // $path = resource_path("views/applications/designs/").$ref_no;
            // if(!File::isDirectory($path)) {
            //     File::makeDirectory($path, 0774, true, true);

            //     file_put_contents($path.'/datasource_flow.blade.php', 'Datasource Flow');
            //     file_put_contents($path.'/design_flow.blade.php', 'Design Flow');
            // }

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), ['input' => $validated_data]);
            return redirect()->back()->withInput()->with('warning',"An error has occured while creating Application and Dataset");
        }
        
        Log::channel('db')->info('Application and Dataset Template created successfully', [$application, $dataset_template, ['created_by' => Auth()->user()->email]]);
        return redirect()->route('applications.index')->with('success', 'Application created successfully');
    }

    public function show(string $id)
    {
        return redirect()->route('applications.summary', $id);
    }

    public function edit(Application $application)
    {
        $form_controls = $this->form_controls($application);
        $is_cloned = 0;
        return view('applications.edit', compact('application', 'form_controls', 'is_cloned'));
    }

    public function update(HttpRequest $request, Application $application)
    {
        $validated_data = $this->validate_form_controls($request, $application);
        $name = strtolower($validated_data['name']);
        $ref_no = implode('-',explode(' ',$name));
        $validated_data['ref_no'] = $ref_no;
        $uploadedImages = $request->file();
        if($uploadedImages && $uploadedImages['web_page_screenshots']){
            $screenshots = $this->handleImages($uploadedImages['web_page_screenshots']);
            $validated_data['web_page_screenshots'] = json_encode($screenshots);
        }
        else{
            unset($validated_data['web_page_screenshots']);
        }
        
        $validated_data['container_info'] = isset($validated_data['container_info'])?json_encode($validated_data['container_info']):null;

        $template_data = [];
        if(isset( $validated_data['fields'])){
            $template_data = $validated_data['fields'];
            unset($validated_data['fields']);
        }

        DB::beginTransaction();
        try {
            $validated_data['status'] = true;
            $application->update($validated_data);
            if($validated_data['is_cloned'] == false) {
                $application->dataset_template->update(['template_data' => json_encode($template_data)]);
            }
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), ['input' => $validated_data]);
            dd($e->getMessage());
            return redirect()->back()->withInput()->with('warning',"An error has occured while creating Application and Dataset");
        }

        Log::channel('db')->info('Application and Dataset Template updated successfully', [$application, $application->dataset_template, ['modified_by' => Auth()->user()->email]]);
        
        if($validated_data['is_cloned'] == true) {
            //save to job
            BackendJob::create([
                'action_name' => 'create_application',
                'application_id' => $application->id,
                'payload' => json_encode($application),
                'user_id' => Auth()->user()->id
            ]);
            return redirect()->route('my-apps.index')->with('success', 'Application created successfully');
        }
        return redirect()->route('applications.index')->with('success', 'Application updated successfully');
    }

    public function destroy(string $id)
    {
    }

    private function validate_form_controls($request, $application = null)
    {
        $validation_rules = [
            'name' => 'required|unique:applications,name',
            'documentation_link' => 'nullable|url:http,https',
            'web_page_screenshots.*' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'ref_no' => 'nullable',
            'folder_name' => 'nullable',
            'container_info' => 'nullable',
            'fields' => 'nullable',
            'creator_id' => 'nullable',
            'status' => 'nullable',
            'is_cloned' => 'nullable',
        ];

        if(!is_null($application)){
            $validation_rules['name'] = 'required|unique:applications,name,' . $application->id;
        }

        return $this->validate($request, $validation_rules);
    }

    private function handleImages($web_page_screenshots, $application=null){
        // Delete Old Screenshots
        if (!is_null($application) && count($web_page_screenshots)) { // if empty, ignore delete
            $old_screenshots = json_decode($application->web_page_screenshots, true);
            foreach ($old_screenshots as $old_screenshot) {
                unlink(public_path('media/images/applications/web_page_screenshots/') . $old_screenshot['filename']);
            }
        }

        // Create JSON for New Screenshots and Move to directory
        $screenshots_json_arr = [];
        foreach ($web_page_screenshots as $key => $screenshot) {
            $filename = $key . time() . '.' . $screenshot->extension();

            /* Load, resize and save the screenshot
            $img = Image::make($screenshot);
            $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(public_path('media/images/applications/web_page_screenshots/').$filename);*/

            $screenshot->move(public_path('media/images/applications/web_page_screenshots/'), $filename);
            $screenshots_json_arr[] = ['filename' => $filename, 'name' => 'Screenshot ' . $key + 1];
        }
        
        return $screenshots_json_arr;
    }

    private function form_controls($application = null, $viewonly = false, $isCloned = false)
    {
        $form_controls = [];
        $required = ($viewonly) ? '' : 'required';

        // Name
        $form_controls['Application Information'][] = FormControls::grid_col(
            12,
            FormControls::text_control(
                'name',
                $application->name ?? null,
                ['id' => 'name', 'class' => '', 'placeholder' => 'Application Name', 'title' => 'Application Name', 'readonly' => $viewonly, 'disabled' => $viewonly, "$required", 'maxlength' => 50],
                ['text' => 'Application Name:']
            )
        );
        // Short Description
        $form_controls['Application Information'][] = FormControls::grid_col(
            12,
            FormControls::text_control(
                'short_description',
                $application->short_description ?? null,
                ['id' => 'short_description', 'class' => '', 'placeholder' => 'Short Description', 'title' => 'Short Description', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, "$required", 'maxlength' => 255],
                ['text' => 'Short Description:']
            )
        );
        // Ref No
        // $form_controls['Application Information'][] = FormControls::grid_col(
        //     6,
        //     FormControls::text_control(
        //         'ref_no',
        //         $application->ref_no ?? null,
        //         ['id' => 'ref_no', 'class' => '', 'placeholder' => 'Ref No', 'title' => 'Ref No', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, 'maxlength' => 255],
        //         ['text' => 'Ref No:']
        //     )
        // );
        // Application Flow
        // $form_controls['Application Information'][] = FormControls::grid_col(
        //     6,
        //     FormControls::text_control(
        //         'application_flow',
        //         $application->application_flow ?? null,
        //         ['id' => 'application_flow', 'class' => '', 'placeholder' => 'Application Flow', 'title' => 'Application Flow', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, 'maxlength' => 255],
        //         ['text' => 'Application Flow:']
        //     )
        // );
        // Remarks
        $form_controls['Application Information'][] = FormControls::grid_col(
            12,
            FormControls::textarea_control(
                'remarks',
                $application->remarks ?? null,
                ['id' => 'remarks', 'class' => '', 'placeholder' => 'Remarks', 'title' => 'Remarks', 'autocomplete' => 'off', 'rows' => 3, 'readonly' => $viewonly, 'disabled' => $viewonly, 'maxlength' => 255],
                ['text' => 'Remarks:']
            )
        );

        // Web Page Screenshots 
        $web_page_screenshots = [];
        if( $isCloned == false){
            if (!is_null($application)) {
                $web_page_screenshots = $application->web_page_screenshots ? json_decode($application->web_page_screenshots, true) : [];
                $form_controls['Application Information'][] = FormControls::grid_col(
                    12,
                    FormControls::form_control_group('form-group', [
                        'label' => ['for' => 'screenshot_carousel', 'text' => 'Web Page Screenshots:', 'properties' => ['class' => 'form-label']],
                        FormControls::carousel_control($web_page_screenshots, 'applications/web_page_screenshots', 'screenshot_carousel', 0, 720)
                    ])
                );
            }
            if (!$viewonly) {
                $screenshot_label = (is_null($application)) ? 'Upload Web Page Screenshots:' : 'Upload Web Page Screenshots (upload to overwrite):';
                $form_controls['Application Information'][] = FormControls::grid_col(
                    12,
                    FormControls::file_upload_control(
                        'web_page_screenshots[]',
                        ['id' => 'web_page_screenshots', 'class' => '', 'title' => 'Web Page Screenshots', 'autocomplete' => 'off', 'accept' => 'image/*', 'multiple' => 'multiple'],
                        ['text' => $screenshot_label]
                    )
                );
            }
        }
        
       
        // Dataset Template
        $fields = [];
        if (!is_null($application) && $application->dataset_template) {
            $fields = ($application->dataset_template->template_data);
        }
        
        // Tabs
        $activeTab = 0;
        if($isCloned == true) {
            // Container Info
            $container_info_controls =
            [
                FormControls::grid_col(
                    4,
                    FormControls::number_control(
                        'host_port',
                        $application->host_port ?? null,
                        ['id' => 'host_port', 'class' => '', 'placeholder' => 'Host Port', 'title' => 'Host Port', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, "$required"],
                        ['text' => 'Host Port:']
                    )
                ),
                FormControls::grid_col(
                    4,
                    FormControls::number_control(
                        'container_port',
                        $application->container_port ?? null,
                        ['id' => 'container_port', 'class' => '', 'placeholder' => 'Container Port', 'title' => 'Container Port', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, "$required"],
                        ['text' => 'Container Port:']
                    )
                ),
                FormControls::grid_col(
                    4,
                    FormControls::number_control(
                        'timeout',
                        $application->timeout ?? null,
                        ['id' => 'timeout', 'class' => '', 'placeholder' => 'Timeout', 'title' => 'Timeout', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, "$required"],
                        ['text' => 'Timeout (in seconds):']
                    )
                ),
                FormControls::grid_col(
                    4,
                    FormControls::number_control(
                        'cpu_limit',
                        $application->cpu_limit ?? null,
                        ['id' => 'cpuLimit', 'class' => '', 'placeholder' => 'CPU Limit', 'title' => 'CPU Limit', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, "$required"],
                        ['text' => 'CPU Limit:']
                    )
                ),
                FormControls::grid_col(
                    4,
                    FormControls::number_control(
                        'memory_limit',
                        $application->memory_limit ?? null,
                        ['id' => 'memoryLimit', 'class' => '', 'placeholder' => 'Memory Limit', 'title' => 'Memory Limit', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, "$required"],
                        ['text' => 'Memory Limit(GB):']
                    )
                ),
                FormControls::grid_col(
                    4,
                    FormControls::number_control(
                        'gpu_limit',
                        $application->gpu_limit ?? null,
                        ['id' => 'gpuLimit', 'class' => '', 'placeholder' => 'GPU Limit', 'title' => 'GPU Limit', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, "$required"],
                        ['text' => 'GPU Limit:']
                    )
                ),
                FormControls::grid_col(
                    12,
                    FormControls::textarea_control(
                        'container_info',
                        $application->container_info ?? null,
                        ['id' => 'dockerInfo', 'class' => '', 'placeholder' => 'Please enter docker info with JSON format', 'title' => 'Docker Info', 'autocomplete' => 'off', 'rows' => 10, 'readonly' => $viewonly, 'disabled' => $viewonly, "$required"],
                        ['text' => 'Docker Info (JSON format):']
                    )
                )
            ];

            $tabArray = [ 
                            FormControls::tab_control(
                                'container_info_tab',
                                'Container Info',
                                FormControls::grid_row($container_info_controls)
                            )
                        ];
        }
        else{
            // Documentation Link
            $documentation_link_control = FormControls::text_control(
                'documentation_link',
                $application->documentation_link ?? null,
                ['id' => 'documentation_link', 'class' => 'container mt-2', 'placeholder' => 'https://example.com', 'title' => 'URL to Documentation Link', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly],
                ['text' => 'Doc Link:']
            );
            // Description
            $full_description_control = FormControls::ckeditor_control(
                'full_description',
                $application->full_description ?? null,
                ['id' => 'full_description', 'class' => 'ms-0', 'placeholder' => 'Full Description', 'title' => 'Description', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, 'rows' => 10],
                null,
                'mt-2'
            );
            
            $tabArray = [FormControls::tab_control(
                    'full_description_tab',
                    'Full Description',
                    $full_description_control
                ),
                FormControls::tab_control(
                    'documentation_link_tab',
                    'Documentation Link',
                    $documentation_link_control
                ),
                FormControls::tab_control(
                    'dataset_template_tab',
                    'Dataset Template',
                    view('services.dataset_templates.builder_component', compact('fields', 'viewonly'))
                ),
            ];
        }

        $form_controls['Service Information'][] =
            FormControls::grid_col(
                12,
                FormControls::tabs_control(
                    'other_controls',
                    $tabArray,
                    $activeTab,
                    //'nav-tabs-block block-header m-0 p-0 justify-content-start border'
                    'nav nav-tabs pt-4 me-4',
                    'ps-0'
                ),
                'm-0 mt-4 py-4 '//border
            );

        return $form_controls;
    }

    // Application Management
    public function summary(HttpRequest $request, string $id)
    {
        $application = Application::find($id);
        if (is_null($application)) {
            $request->session()->flash('warning', config('global.app_not_found'));
            return redirect()->route('applications.index');
        }
        Log::info($application->operation_pages);
        $app_screenshots = $application->web_page_screenshots;
        $web_page_screenshots = $app_screenshots ? json_decode($app_screenshots, true) : [];
        $carousel_control = FormControls::carousel_control($web_page_screenshots, 'web_page_screenshots', 'web_page_screenshot_carousel', 0, 720);
        $carousel = count($web_page_screenshots) ? $carousel_control : '';

        return view('applications.management.summary', compact('application', 'carousel'));
    }

    public function resources(HttpRequest $request, string $id)
    {
        $application = Application::find($id);
        if (is_null($application)) {
            $request->session()->flash('warning', config('global.app_not_found'));
            return $this->index();
        }
        return view('applications.management.resources', compact('application'));
    }
    public function operations(HttpRequest $request, string $id, string $route_name)
    {
        $application = Application::find($id);
        if (is_null($application)) {
            $request->session()->flash('warning', config('global.app_not_found'));
            return $this->index();
        }

        $page = $application->operation_page($route_name);
        if (is_null($page)) {
            $request->session()->flash('warning', 'Page Not Found');
            return redirect()->route('applications.summary', ['id' => $id]);
        }
        return redirect()->route($route_name, ['id' => $id]);
    }

    public function services(HttpRequest $request, string $id)
    {
        $application = Application::find($id);
        if (is_null($application)) {
            $request->session()->flash('warning', config('global.app_not_found'));
            return redirect()->route('applications.index');
        }
        return view('applications.management.services', compact('application'));
    }

    public function logs(HttpRequest $request, string $id)
    {
        if($request->ajax()){
            
            return [];
        }else{
            $application = Application::find($id);
            if (is_null($application)) {
                $request->session()->flash('warning', config('global.app_not_found'));
                return redirect()->route('applications.index');
            }
        }
        return view('applications.management.logs', compact('application'));
    }

    // Application State Control
    public function control(HttpRequest $request, string $id, string $action)
    {
        $actionName = strtolower($action).'_application';
        $application = Application::select('id', 'name', 'ref_no', 'state')->where('id', $id)->first();
        $application->under_state_changing = strtolower($action);
        $application->update();

        BackendJob::create([
            'action_name' => $actionName, // start_application, stop_application, restart_application
            'application_id' => $application->id,
            'payload' => json_encode($application),
            'user_id' => Auth()->user()->id
        ]);

        return response()->json(['success'=> true], 200);
    }

    public function loadStateControlComponent(HttpRequest $request, Application $application) {
        return view('myapps/components/state_controls', compact('application'));
    }
    public function loadResourceUsagesComponent(HttpRequest $request, Application $application) {
        $resource_usages = $application->resource_usages;
        return view('myapps/components/resource_usages', compact('application', 'resource_usages'));
    }
}