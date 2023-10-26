<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use DB;
use Hash;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Builder\FormControls;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:department-list');
        $this->middleware('permission:department-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:department-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:department-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Department::select('*')->where('status', '!=', 2);

            return Datatables::of($data)
                ->addColumn('actions', function ($row) {
                    $buttons = "";
                    $buttons .= FormControls::anchor_control(route('departments.edit', $row->id), 'Edit Department', 'edit btn btn-primary btn-sm me-1 text-white', 'fa-edit');
                    $buttons .= FormControls::dt_control(['id' => $row->id], 'Delete Department', 'btn btn-sm btn-danger me-1 dtable-row-action-delete', 'fa-trash');
                    return $buttons;
                })->rawColumns(['actions'])->make(true);
        } else {
            return view('departments.index');
        }
    }

    private function form_controls($info = null, $viewonly = false)
    {
        $form_controls = [];
        $required = ($viewonly) ? '' : 'required';

        $form_controls['Department Info'][] = FormControls::grid_col(
            4,
            FormControls::text_control(
                'name',
                $info->name ?? null,
                ['id' => 'departmentName', 'class' => '', 'placeholder' => 'Name', 'title' => 'Name', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, "$required"],
                ['text' => 'Name:']
            )
        );
        $form_controls['Department Info'][] = FormControls::grid_col(
            12,
            FormControls::text_control(
                'desc',
                $info->desc ?? null,
                ['id' => 'departmentDesc', 'class' => '', 'placeholder' => 'Desc', 'title' => 'desc', 'autocomplete' => 'off', 'readonly' => $viewonly, 'disabled' => $viewonly, "$required"],
                ['text' => 'Desc:']
            )
        );
        return $form_controls;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = Department::find($id);
        $form_controls = $this->form_controls($info, true);
        return view('departments.show', compact('form_controls', 'info'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $form_controls = $this->form_controls();
        return view('Departments.create', compact('form_controls'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'desc' => 'required',
        ]);
        $input = $request->all();
        $input['status'] = 1;
        $DepartmentInfo = Department::create($input);
        $DepartmentInfo->created_by = Auth::user()->email;
        Log::channel('db')->info('Created Department', [$DepartmentInfo]);
        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = Department::find($id);
        $form_controls = $this->form_controls($info, false);
        return view('departments.edit', compact('form_controls', 'info'));
    }


    public function update(Request $request, department $department)
    {
        $this->validate($request, [
            'name' => 'required',
            'desc' => 'required',
        ]);
        $input = $request->all();
        $department->update($input);
        $input['created_by'] = Auth::user()->email;
        Log::channel('db')->info('Updated Department', $input);

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Department::where('id', $id)->update(['status' => 2]);
        $data = [];
        $data['id'] = $id;
        $data['deleted_by'] = Auth::user()->email;
        Log::channel('db')->info('Deleted Department', [$data]);
        return response()->json(['status' => 'success', 'message' => "Department deleted successfully"], 200);
    }


}
