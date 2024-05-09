<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\CaseResource;
use App\Models\AdminFee;
use App\Models\Cases;
use App\Models\Client;
use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        set_page_meta('Reports');


        $items = CaseResource::collection(Cases::orderBy('id','DESC')->get());



        $total = Cases::count();
        $dbBalanceData = [
            "items"=>$items,
            "total"=>$total
        ];
//        return  $dbBalanceData;
//        dd($dbBalanceData);

        return view('admin.reports.report',compact('dbBalanceData'));
    }

    public function saleDoughnutChartData()
    {
        $orders = DB::table('cases')
            ->select('current_status', DB::raw('count(*) as total'))
            ->groupBy('current_status')
            ->get();

        //return $orders;
//        open #670016
//        closed #02522f,
//        pending #f4511e,

        $backgrounds = ['#670016', '#02522f', '#f4511e'];
        $counts = [];
        $statuses = [];
        $colors = [];
        foreach ($orders as $key=>$order){
            $counts[]= $order->total;
            $statuses[] = $order->status;
            $colors[] = $backgrounds[$key];
        }
        $data = [
            'counts'=>$counts,
            'statuses'=>$statuses,
            'colors'=>$colors,
        ];
        return response()->json(['status'=>200,'data'=>$data]);

    }

    public function adminFeeLineChartData()
    {
        $dataArray = AdminFee::selectRaw('year(collection_date) year, monthname(collection_date) month, sum(admin_fee_amount) admin_fees')
            ->where("collection_date", ">", \Illuminate\Support\Carbon::now()->subMonths(13))
            ->groupBy('year', 'month')
            ->orderBy('collection_date', 'ASC')
            ->get();
        $month_name_array = array();
        $monthly_order_count_array = array();
        if ($dataArray->count() != 0) {
            foreach ($dataArray as $data) {
                $unformated_date = $data->month . '-' . $data->year;
                $date = new \DateTime($unformated_date);
                $month_name = $date->format('M-y');
                array_push($month_name_array, $month_name);
                array_push($monthly_order_count_array, $data->orders);
            }
        }

        $monthly_order_data_array = array(
            'months' => $month_name_array,
            'orders' => $monthly_order_count_array,
        );

        //return $monthly_order_data_array;
        return response()->json(['status'=>200,'data'=>$monthly_order_data_array]);
    }

    public function installmentBarChartData()
    {
        $dataArray = Installment::selectRaw('year(date_of_payment) year, monthname(date_of_payment) month, sum(amount_paid) installments')
            ->where("date_of_payment", ">", \Illuminate\Support\Carbon::now()->subMonths(13))
            ->groupBy('year', 'month')
            ->orderBy('date_of_payment', 'ASC')
            ->get();
        $month_name_array = array();
        $monthly_order_count_array = array();
        if ($dataArray->count() != 0) {
            foreach ($dataArray as $data) {
                $unformated_date = $data->month . '-' . $data->year;
                $date = new \DateTime($unformated_date);
                $month_name = $date->format('M-y');
                array_push($month_name_array, $month_name);
                array_push($monthly_order_count_array, $data->orders);
            }
        }

        $monthly_order_data_array = array(
            'months' => $month_name_array,
            'orders' => $monthly_order_count_array,
        );

        //return $monthly_order_data_array;
        return response()->json(['status'=>200,'data'=>$monthly_order_data_array]);
    }

    public function debtorBalanceTableData(Request $request)
    {
//        $items = CaseResource::collection(Cases::orderBy('id','DESC')->paginate($request->per_page));
        $items = CaseResource::collection(Cases::orderBy('id','DESC')->get());
        $total = Cases::count();
        $data = [
            "items"=>$items,
            "total"=>$total
        ];


        return response()->json(['status'=>200,'data'=>$data]);

    }
}


