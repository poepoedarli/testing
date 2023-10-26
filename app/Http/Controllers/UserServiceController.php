<?php

namespace App\Http\Controllers;

//use App\Models\OrderServiceVersion;
//use App\Models\ApplicationLog;
//use Carbon\Carbon;
//use Illuminate\Contracts\Foundation\Application;
//use Illuminate\Contracts\View\Factory;
//use Illuminate\Contracts\View\View;
//use Illuminate\Http\Request;
//use DB;
//use Hash;
//use DataTables;
//use Illuminate\Http\Response;
//use Illuminate\Support\Facades\Auth;
//
//
class UserServiceController extends Controller
{
//
//    function __construct()
//    {
//        $this->middleware('permission:user-service-list');
//    }
//
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//
//    public function index(Request $request)
//    {
//        if ($request->ajax()) {
//            $user = Auth::user();
//            if ($user->hasRole('Admin')) {
//                $data = OrderServiceVersion::with('serviceVersion.service')
//                    ->with(['user'])
//                    ->whereHas('order', function ($query) {
//                        $query->where('order_status', 2);
//                    })
//                    ->select("*")->get();
//            } else {
//                $data = OrderServiceVersion::with('serviceVersion.service')
//                    ->with('user')
//                    ->whereHas('order', function ($query) {
//                        $query->where('order_status', 2);
//                    })
//                    ->where('user_id', $user->id)
//                    ->select("*")->get();
//            }
//            return Datatables::of($data)
//                ->editColumn('status', function ($row) {
//                    return match ($row->status) {
//                        "1" => "stop",
//                        "2" => "running",
//                    };
//                })
//                ->addColumn('service', function ($row) {
//                    return $row->serviceVersion->service->name . $row->serviceVersion->version;
//                })
//                ->addColumn('host_port', function ($row) {
//                    return $row->serviceVersion->host_port;
//                })
//                ->addColumn('container_port', function ($row) {
//                    return $row->serviceVersion->container_port;
//                })
//                ->addColumn('timeout', function ($row) {
//                    return $row->serviceVersion->timeout;
//                })
//                ->addColumn('cpu_limit', function ($row) {
//                    return $row->serviceVersion->cpu_limit;
//                })
//                ->addColumn('gpu_limit', function ($row) {
//                    return $row->serviceVersion->gpu_limit;
//                })
//                ->addColumn('memory_limit', function ($row) {
//                    return $row->serviceVersion->memory_limit;
//                })
//                ->addColumn('user_name', function ($row) {
//                    return $row->user->name;
//                })
//                ->addColumn('actions', function ($row) {
//                    $buttons = '';
//                    if (Auth::user()->can('confirm-service')) {
//                        $serviceName = $row->serviceVersion->service->name . $row->serviceVersion->version;
//                        if ($row->status == 1) {
//                            $buttons = "<button type='button' id='user_order_service_$row->id' onclick='startService($row->id)' data-service-name='$serviceName' class='btn btn-primary'>start</button>";
//                        } else {
//                            $buttons = "<button type='button' id='user_order_service_$row->id' onclick='stopService($row->id)'  data-service-name='$serviceName' class='btn btn-warning'>stop</button>";
//                        }
//                    }
//                    return $buttons;
//                })->
//                rawColumns(['actions', 'service'])->make(true);
//        } else {
//            return view('userService.index');
//        }
//    }
//
//    public function confirmService(Request $request)
//    {
//        $validation_rules = [
//            'id' => 'required',
//            'confirmType' => 'required',
//        ];
//        $this->validate($request, $validation_rules);
//        $id = $request->input(['id']);
//        $confirmType = $request->input(['confirmType']);
//        //Modify Application Status
//        OrderServiceVersion::where('id', $id)->update([
//            'status' => $confirmType,
//        ]);
//        //Record service startup/shutdown logs
//        $logTitle = "startService";
//        if ($confirmType == 1) {
//            $logTitle = "stopService";
//        }
//        $logData = [
//            'title' => $logTitle,
//            'category' => "info",
//            'user_id' => Auth::user()->id,
//            'content' => json_encode(['order_service_version_id', $id]),
//            'created_at' => Carbon::now()->timezone('Asia/Singapore'),
//        ];
//        ApplicationLog::insert($logData);
//    }
}