<?php
    
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::select('*');
            return Datatables::of($data)
                ->addColumn('action', function($row){
                    $actionBtn = '';
                    if($row->id == 1){
                        // No action is required
                    }else{
                        if(Auth::user()->hasRole('Super Admin')){
                            $actionBtn .= "<a href='".route('roles.edit', $row->id)."' class='edit btn btn-primary btn-sm me-1 text-white'><i class='fa fa-edit'></i></a>";
                        }
                        if(Auth::user()->hasRole('Super Admin')) {
                            $actionBtn .= "<a data-id='".$row->id."' class='delete btn btn-danger btn-sm dtable-row-action-delete  text-white'> <i class='fa fa-trash'></i></a>";
                        }
                    }
                    
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }else{
            return view('roles.index');
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        //logging
        $role->created_by = Auth::user()->email;
        Log::channel('db')->info('Created Role', [$role]);
    
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('roles.show',compact('role','rolePermissions'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        if($id == 1 || is_null($role)) {
            return redirect()->route('roles.index')->with('warning', "Please don't try to fix this role name.");
        }
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('roles.edit',compact('role','permission','rolePermissions'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        //logging
        $role->modified_by = Auth::user()->email;
        Log::channel('db')->info('Modified Role', [$role]);
    
        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        
        //logging
        $data = [];
        $data['id'] = $id;
        $data['deleted_by'] = Auth::user()->email;
        Log::channel('db')->info('Deleted Site', [$data]);

        return response()->json(['status' => 'success',  'message' => "Role deleted successfully"], 200);
        //return redirect()->route('roles.index')->with('success','Role deleted successfully');
    }

    public function deleteRole($id){
        DB::table("roles")->where('id',$id)->delete();
        $request->session()->flash('success', 'Task was successful!');

        //logging
        $data = [];
        $data['id'] = $id;
        $data['deleted_by'] = Auth::user()->email;
        Log::channel('db')->info('Deleted Role', [$data]);

        return response()->json(['status' => 'success',  'message' => "Role deleted successfully"], 200);
    }
}