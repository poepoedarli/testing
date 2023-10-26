<?php
//
//namespace App\Http\Controllers;
//
//use App\Models\OrderServiceVersion;
//use App\Models\ApplicationVersion;
//use Exception;
//use Illuminate\Http\Request;
//use App\Models\order;
//
//use DB;
//use Hash;
//use DataTables;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Log;
//use Carbon\Carbon;
//
//
class OrderController extends Controller
{
//
//    function __construct()
//    {
//        $this->middleware('permission:order-list');
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
//                $data = order::with('user')->with("orderServiceVersion")->select('*')->get();
//            } else {
//                $data = order::with('user')->where('user_id', $user->id)->select('*')->get();
//            }
//            foreach ($data as $k => $order) {
//                foreach ($order['orderServiceVersion'] as $key => $value) {
//                    $serviceInfo = ApplicationVersion::with('service')->where('id', $value['service_version_id'])->select('*')->get();
//                    $data[$k]['orderServiceVersion'][$key]['serviceInfo'] = $serviceInfo;
//                }
//            }
//            return Datatables::of($data)
//                ->editColumn('order_status', function ($row) {
//                    return match ($row->order_status) {
//                        "1" => "unpaid",
//                        "2" => "paid",
//                        default => "bill",
//                    };
//                })
//                ->addColumn('user', function ($row) {
//                    return $row->user->name;
//                })
//                ->editColumn('price', function ($row) {
//                    return $row->amount . " " . $row->currency_type;
//                })
//                ->editColumn('services', function ($row) {
//                    $serviceText = "";
//                    foreach ($row['orderServiceVersion'] as $value) {
//
//                        foreach ($value['serviceInfo'] as $service) {
//                            $serviceText .= $service['service']['name'] . $service['version'] . "<br>";
//                        }
//                    }
//                    return $serviceText;
//                })
//                ->addColumn('action', function ($row) {
//                    if ($row->order_status == 1 && Auth::user()->can('payment-order')) {
//                        return "<button  id='order_$row->id' onclick='payment($row->id)'  class='btn btn-primary'>Payment</button>";
//                    } else {
//                        return '';
//                    }
//                })->rawColumns(['services', 'action'])->make(true);
//        } else {
//            return view('order.index');
//        }
//    }
//
//    public function submitOrder(Request $request)
//    {
//        $validation_rules = [
//            'serviceVersionIds' => 'required',
//        ];
//        $this->validate($request, $validation_rules);
//        $user = Auth::user();
//        $userId = $user->id;
//        $serviceVersionIds = $request->input('serviceVersionIds');
//        $serviceVersion = ApplicationVersion::select('*')->whereIn('id', $serviceVersionIds)->get();
//        $amount = 0;
//        $currencyType = '';
//        foreach ($serviceVersion as $value) {
//            $amount += $value['price'];
//            $currencyType = $value['currency_type'];
//        }
//        try {
//            DB::beginTransaction();
//            $orderData = [
//                'user_id' => $userId,
//                'created_at' => Carbon::now()->timezone('Asia/Singapore'),
//                'order_status' => 1,
//                'amount' => $amount,
//                'currency_type' => $currencyType,
//            ];
//            $orderInfo = Order::create($orderData);
//            $orderId = $orderInfo['id'];
//
//            $orderServiceVersionData = [];
//            foreach ($serviceVersion as $value) {
//                $data = [];
//                $data['user_id'] = $userId;
//                $data['order_id'] = $orderId;
//                $data['service_version_id'] = $value['id'];
//                $data['final_price'] = $value['price'];
//                $data['currency_type'] = $value['currency_type'];
//                $data['status'] = 1;
//                $data['created_at'] = Carbon::now()->timezone('Asia/Singapore');
//                $orderServiceVersionData[] = $data;
//            }
//            OrderServiceVersion::insert($orderServiceVersionData);
//            DB::commit();
//
//        } catch (Exception $e) {
//            DB::rollback();
//            Log::channel('db')->error('submitOrderErr', [$e->getMessage()]);
//            return response()->json(['data' => ['msg' => "order generation failed"]], 200);
//
//        }
//        return response()->json(['data' => ['msg' => "order generated successfully"]], 200);
//    }
//
//    public function payment(Request $request)
//    {
//        $validation_rules = [
//            'id' => 'required',
//        ];
//        $this->validate($request, $validation_rules);
//        $id = $request->input(['id']);
//        Order::where('id', $id)->update([
//            'order_status' => 2,
//            'pay_time' => Carbon::now()->timezone('Asia/Singapore'),
//        ]);
//        return response()->json(['data' => ['msg' => "Payment successful"]], 200);
//    }
//
}