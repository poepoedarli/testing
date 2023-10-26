<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Yoeriboven\LaravelLogDb\Models\LogMessage;
use DB;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class LogController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:logs-audit', ['only' => ['auditLogs', 'deleteAuditLogs']]);
        $this->middleware('permission:logs-system', ['only' => ['systemLogs','deleteSystemLogs']]);
    }
    
    public function auditLogs(Request $request)
    {
        if ($request->ajax()) {
            //dd($request);
            $data = AuditLog::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at_readable', function($row){
                    return date("Y-m-d H:i:s", strtotime($row->created_at));
                })
                ->addColumn('type-badge', function($row){
                    $colors = ['info'=>'info', 'warning'=>'warning', 'error'=>'danger', 'alert'=>'success'];
                    return "<span style='cursor: default' class='btn btn-sm text-white btn-".$colors[trim($row->type)]."'> ".strtoupper(trim($row->type))."</a> ";
                })
                ->rawColumns(['type-badge'])
                ->make(true);
        }else{
            
            return view('logs.audit');
        }
    }

    public function systemLogs(Request $request)
    {
        if ($request->ajax()) {
            $inputs = $request->input();
            $columns = $inputs['columns'];
            $filter_by_context = '';
            $filter_by_extra = '';
            foreach ($columns as $key => $col) {
                if($col['name'] == 'context' && $col['search']['value'] !=null) {
                    $filter_by_context = strtolower($col['search']['value']);
                    /* DB::enableQueryLog();
                    $abc = LogMessage::whereRaw('context like ?', "%$searchterm%")->get();
                    dd($abc); */
                }
                else if($col['name'] == 'extra' && $col['search']['value'] !=null){
                    $filter_by_extra = strtolower($col['search']['value']);
                }
            }
            
            $data = LogMessage::select('*')
                        ->when($filter_by_context, function ($query) use ($filter_by_context) {
                            return $query->whereRaw('LOWER(context) like ?', "%$filter_by_context%");
                        })
                        ->when($filter_by_extra, function ($query) use ($filter_by_extra) {
                            return $query->whereRaw('LOWER(extra) like ?', "%$filter_by_extra%");
                        });
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('logged_at_readable', function($row){
                    return Carbon::createFromTimestamp(strtotime($row->logged_at))->timezone('Asia/Singapore')->toDateTimeString();
                })
                ->addColumn('context', function($row){
                    return json_encode($row->context, JSON_UNESCAPED_SLASHES);
                })
                ->addColumn('type-badge', function($row){
                    $colors = ['info'=>'info', 'warning'=>'warning', 'error'=>'danger', 'alert'=>'success', 'debug'=>'info'];
                    return "<span style='cursor: default' class='btn btn-sm text-white btn-".$colors[strtolower($row->level_name)]."'> ".$row->level_name."</a> ";
                })
                ->rawColumns(['type-badge'])
                ->make(true);
        }else{
            
            return view('logs.system');
        }
    }

    function deleteAuditLogs(){
        AuditLog::where('deleted_at', NULL)->delete();
        return response()->json(['status' => 'success',  'message' => "Audit Logs deleted successfully"], 200);
    }

    function deleteSystemLogs(){
        LogMessage::where('deleted_at', NULL)->delete();
        return response()->json(['status' => 'success',  'message' => "System Logs deleted successfully"], 200);
    }
    
}