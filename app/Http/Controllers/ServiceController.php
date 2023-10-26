<?php

namespace App\Http\Controllers;

use App\Builder\FormControls;
use App\Models\Service;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:service-list');
        $this->middleware('permission:service-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:service-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:service-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $services = Service::select('*')->orderBy('name', 'asc')->get();
        return view('services.index', compact('services'));
    }

    public function create(HttpRequest $request)
    {
        $form_controls = $this->form_controls();
        return view('services.create', compact('form_controls'));
    }

    public function store(HttpRequest $request)
    {
        $validated_data = $this->validate_form_controls($request);
        $data = $request->input() + $validated_data;
        
        $data['creator_id'] = Auth()->user()->id;
        $service = Service::create($data);

        $service->creator_by = Auth()->user()->email;
        Log::channel('db')->info('Created Service', [$service]);
        return redirect()->route('services.index')->with('success', 'Service created successfully');
    }

    public function show(HttpRequest $request, Service $service)
    {
        $form_controls = $this->form_controls($service, true);
        return view('services.show', compact('service', 'form_controls'));
    }

    public function edit(HttpRequest $request, string $id)
    {
        $service = Service::find($id);
        if (is_null($service)) {
            $request->session()->flash('warning', 'Service Not Found');
            return $this->index();
        }
        $form_controls = $this->form_controls($service);
        return view('services.edit', compact('service', 'form_controls'));
    }

    public function update(HttpRequest $request, Service $service)
    {
        $validated_data = $this->validate_form_controls($request, $service);
        $data = $request->input() + $validated_data;
        $service->update($data);

        $service->modified_by = Auth()->user()->email;
        Log::channel('db')->info('Modified Service', [$service]);

        return redirect()->route('services.index')->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        //logging
        $data = [];
        $data['id'] = $service->id;
        $data['deleted_by'] = Auth::user()->email;
        
        $service->delete();

        Log::channel('db')->info('Deleted Service', [$data]);

        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }
    
    private function validate_form_controls($request, $service = null)
    {
        $validation_rules = [
            'name' => 'required',
        ];

        if (!is_null($service)) {
            //$validation_rules['name'] .= '|exclude_if:name,' . $service->name;
            //$validation_rules['description'] .= '|exclude_if:description,' . $service->description;
            //$validation_rules['status'] .= '|exclude_if:status,' . $service->status;
        }

        $iconName = NULL;
        $icon = NULL;
        if ($request->file('icon')) {
            $validation_rules['icon'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024';
            $icon = $request->icon;
            $iconName = time() . '.' . $request->icon->extension();
        }

        $validated_data = $this->validate($request, $validation_rules);

        // Icon
        if (!is_null($iconName)) {
            if ($service && $service->icon!='') {//remove old Icon
                if(file_exists(public_path('media/images/services/') . $service->icon)){
                    unlink(public_path('media/images/services/') . $service->icon);
                }
            }
        }
        else{//didn't upload, use default icon
            $iconName = time() . '.png';
            if( is_null($service) ){
                $icon = public_path('media/images/services/default-service-logo.png');
            }
        }

        if(!is_null($icon)){
            // Load the image
            $img = Image::make($icon);

            // resize the image
            $img->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Save the cropped image
            $img->save(public_path('media/images/services/').$iconName);
            $validated_data['icon'] = $iconName;
        }

        return $validated_data;
    }

    private function form_controls($service = null, $viewonly = false)
    {
        $form_controls = [];
        $required = ($viewonly) ? '' : 'required';

        // Icon Image
        $preview_url = asset('media/images/services/default-service-logo.png');
        if (isset($service->icon) && !is_null($service->icon)) {
            $preview_url =  asset('media/images/services/' . $service->icon);
        }
        $form_controls['Service Information'][] = FormControls::grid_col(
            12,
            FormControls::form_control_group('form-group', [
                'label' => ['for' => 'preview-image', 'text' => ' ', 'properties' => ['class' => 'form-label']],
                '<img id="preview-image" width="auto" height="100" src="' . $preview_url . '" class="d-block" />'
            ])
        );

        if (!$viewonly) {
            $form_controls['Service Information'][] = FormControls::grid_col(
                12,
                FormControls::file_upload_control(
                    'icon',
                    ['id' => 'icon', 'class' => '', 'title' => 'Icon', 'autocomplete' => 'off',  'accept' => 'image/*'],
                    ['text' => 'Upload Icon (100x100):']
                )
            );
        }
        
        // Name & Short Description
        $form_controls['Service Information'][] = FormControls::grid_col(
            12,
            FormControls::grid_row(
                [
                    FormControls::grid_col(
                        12,
                        FormControls::text_control(
                            'name',
                            $service->name ?? null,
                            ['id' => 'name', 'class' => '', 'placeholder' => '', 'title' => 'Service Name', 'readonly' => $viewonly, 'disabled' => $viewonly, "$required", 'maxlength' => 100],
                            ['text' => 'Service Name:']
                        )
                    ),
                    FormControls::grid_col(
                        12,
                        FormControls::textarea_control(
                            'description',
                            $service->description ?? null,
                            ['id' => 'description', 'class' => '', 'placeholder' => 'Description', 'title' => 'Description', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, 'rows' =>5],
                            ['text' => 'Description:']
                        )
                    ),
                    FormControls::grid_col(
                        12,
                        FormControls::text_control(
                            'version',
                            $service->version ?? null,
                            ['id' => 'version', 'class' => '', 'placeholder' => '', 'title' => 'Version', 'autocomplete' => 'off', 'readonly' => $viewonly, "$required",'disabled' => $viewonly, 'maxlength' => 10],
                            ['text' => 'Version:']
                        )
                    )
                ]
            )
        );

        // Status
        $form_controls['Service Information'][] = FormControls::grid_col(
            12,
            FormControls::checkbox_control(
                'status',
                $service->status ?? true,
                $service->status ?? true,
                ['id' => 'status', 'class' => '', 'title' => 'Enable/Disable Service', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly],
                ['text' => 'Enabled'],
                true
            )
        );
        
        
        return $form_controls;
    }
}
