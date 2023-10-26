<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use Spatie\Permission\Models\Role;
use App\Rules\MatchOldPassword;
use Illuminate\Validation\Rules\Password;
use DB;
use Hash;
use Illuminate\Support\Arr;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:user-list');
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::select("
                        SELECT v5_users.id, MIN(v5_users.name) as user_name, MIN(v5_users.email) as email, MIN(v5_users.country_code) as country_code, MIN(v5_users.phone) as phone, STRING_AGG(v5_roles.name, ', ') as role_name, MIN(v5_departments.name) as department_name 
                        FROM v5_model_has_roles as p
                        INNER JOIN v5_roles ON v5_roles.id = p.role_id
                        INNER JOIN v5_users ON v5_users.id = p.model_id
                        LEFT JOIN v5_departments ON v5_departments.id = v5_users.department_id
                        GROUP BY v5_users.id
                        ");

            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    if (Auth::user()->can('service-edit') && $row->id > 1) {
                        $actionBtn .= "<a href='" . route('users.edit', $row->id) . "' class='edit btn btn-primary btn-sm  text-white'><i class='fa fa-edit'></i></a> ";
                    }
                    if (Auth::user()->can('service-delete') && $row->id > 1) {
                        $actionBtn .= "<a data-id='" . $row->id . "' class='delete btn btn-danger btn-sm dtable-row-action-delete  text-white'> <i class='fa fa-trash'></i></a>";
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {

            return view('users.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country_codes = Country::pluck('country_code', 'country_code');
        $roles = Role::where('id', '!=', 1)->pluck('name', 'name')->all();
        $departments = Department::pluck('name', 'id')->where('status', '!=', 2)->toarray();
        return view('users.create', compact('roles', 'country_codes', 'departments'));
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
            'email' => 'required|email|unique:users,email',
            'password' => ['required', Password::min(12)->uncompromised()],
            'confirm-password' => 'required|same:password',
            'roles' => 'required',
            'department_id' => 'required|min:1'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        //logging
        $user->created_by = Auth::user()->email;
        Log::channel('db')->info('Created User', [$user]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country_codes = Country::pluck('country_code', 'country_code');
        $user = User::find($id);
        return view('users.show', compact('user', 'country_codes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country_codes = Country::pluck('country_code', 'country_code');
        $user = User::find($id);
        $roles = Role::where('id', '!=', 1)->pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $departments = Department::pluck('name', 'id')->where('status', '!=', 2)->toarray();
        return view('users.edit', compact('user', 'roles', 'userRole', 'country_codes', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable',
            // 'password' => 'same:confirm-password',
            'roles' => 'required',
            'department_id' => 'required|min:1'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        //logging
        $user->modified_by = Auth::user()->email;
        Log::channel('db')->info('Modified User', [$user]);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        //logging
        $data = [];
        $data['id'] = $id;
        $data['deleted_by'] = Auth::user()->email;
        Log::channel('db')->info('Deleted User', [$data]);

        return response()->json(['status' => 'success', 'message' => "User deleted successfully"], 200);
    }

    public function editPassword()
    {
        return view('users.edit_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', Password::min(12)->uncompromised()],
            'new_confirm_password' => ['same:new_password'],
        ]);

        $user = User::where('id', auth()->user()->id)->first();
        $user->update(
            ['password' => Hash::make($request->new_password)]
        );

        return redirect()->route('users.show', ['user' => $user])
            ->with('success', 'Password updated successfully');
    }
}