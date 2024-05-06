<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\AdminFee;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.report');
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

    public function saleGraphChartData()
    {
        $dataArray = AdminFee::selectRaw('year(created_at) year, monthname(created_at) month, count(*) orders')
            ->where("created_at", ">", \Illuminate\Support\Carbon::now()->subMonths(13))
            ->groupBy('year', 'month')
            ->orderBy('created_at', 'ASC')
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
}
