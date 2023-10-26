<?php

namespace App\Http\Controllers;

use App\Builder\FormControls;
use App\Builder\Template;
use App\Models\DatasetTemplate;
use Illuminate\Http\Request as HttpRequest;

class DatasetTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('services.dataset_templates');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.dataset_templates.builder');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HttpRequest $request)
    {
        $application_id = $request->input('application_id');
        $template_data = json_encode($request->input('fields'));
        $remarks = $request->input('remarks');
        dd($template_data);
        $template = DatasetTemplate::create([
            'application_id' => $application_id,
            'template_data' => $template_data,
            'remarks' => $remarks
        ]);
    }

    public function show(string $id)
    {

        $template = DatasetTemplate::find($id);

        $json = '{
            "checkbox-5":{"label":"Enabled","name":"enabled","data_type":"boolean","properties":{"attributes":["id"],"values":["enabled"]}},
            "radiolist-4":{"label":"Gender","name":"gender","data_type":"enum","items":{"labels":["Male","Female"],"values":["M","F"]},"properties":{"attributes":["id"],"values":["gender"]}},
            "select-3":{"label":"Type","name":"type","data_type":"enum","options":{"labels":["Type 1","Type 2","Type 3"],"values":["1","2","3"]},"properties":{"attributes":["id"],"values":["type"]}},
            "fileupload-2":{"label":"Image","name":"path","data_type":"image","properties":{"attributes":["id"],"values":["path"]}},
            "textbox-1":{"label":"Ref No","name":"ref_no","data_type":"string","properties":{"attributes":["id"],"values":["ref_no"]}}}';
        // dd(json_decode($json, true));
        $form_controls = Template::convert_template_to_controls($json);
        return view('services.dataset_templates.template', compact('form_controls', 'template'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(HttpRequest $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}