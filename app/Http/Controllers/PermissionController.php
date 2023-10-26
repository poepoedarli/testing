<?php
    
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use DataTables;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('is_super_admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::select('*');
            return Datatables::of($data)
                ->addColumn('action', function($row){
                    /* $actionBtn = "<a href='".route('permissions.edit', $row->id)."' class='edit btn btn-primary btn-sm me-1 text-white'><i class='fa fa-edit'></i> Edit</a><a data-id='".$row->id."' class='delete btn btn-danger btn-sm dtable-row-action-delete  text-white'> <i class='fa fa-trash'></i> Delete</a>";
                    return $actionBtn; */
                })
                ->rawColumns(['action'])
                ->make(true);
        }else{
            return view('permissions.index');
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        return view('permissions.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
            //'role' => 'required',
        ]);
    
        $permission = Permission::create(['name' => $request->input('name')]);

        $roles = $request->input('role');
        if($roles){
            foreach ($roles as $key => $role_id) {
                $role = Role::where('id', $role_id)->first();
                $role->givePermissionTo($permission);
            }
        }
        return redirect()->route('permissions.index')->with('success','Permission created successfully!');
    }
}