<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\CaseResource;
use App\Models\AdminFee;
use App\Models\Cases;
use App\Models\Client;
use App\Models\Installment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        set_page_meta('Reports');


        $dbBalanceData = Cases::orderBy('id','DESC')->get();
        $adminFee = Client::orderBy('id','DESC')->get();


        //monthly collection bar chart
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
                array_push($monthly_order_count_array, $data->installments);
            }
        }

        $monthly_order_data_array = array(
            'months' => $month_name_array,
            'orders' => $monthly_order_count_array,
        );

        //line chart
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
                array_push($monthly_order_count_array, $data->admin_fees);
            }
        }

       $monthly_admin_fee_data_array = array(
            'months' => $month_name_array,
            'orders' => $monthly_order_count_array,
        );

        //pie chart
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
            $statuses[] = $order->current_status;
            $colors[] = $backgrounds[$key];
        }
        $dataPie = [
            'counts'=>$counts,
            'statuses'=>$statuses,
            'colors'=>$colors,
        ];

        $installmentByEmployees = Installment::select('collected_by_id', \DB::raw('SUM(amount_paid) as installment_total_amounts'))
        ->groupBy('collected_by_id')
            ->with('user')
        ->orderBy('installment_total_amounts', 'desc')
        ->get();

        $adminFeeByEmployees = AdminFee::select('collected_by_id', \DB::raw('SUM(admin_fee_amount) as admin_total_amounts'))
            ->groupBy('collected_by_id')
            ->with('user')
            ->orderBy('admin_total_amounts', 'desc')
            ->get();

        $merged = $installmentByEmployees->concat($adminFeeByEmployees)
            ->groupBy('collected_by_id')
            ->map(function($items) {
                // Convert each item to an array
                $arrays = $items->map(function($item) {
                    return $item->toArray();
                });

                // Merge all arrays
                return $arrays->reduce(function($carry, $item) {
                    return array_merge($carry, $item);
                }, []);
            })->values();

        return view('admin.reports.report',compact('dbBalanceData','adminFee','monthly_order_data_array','monthly_admin_fee_data_array','dataPie','merged'));
    }

    public function monthlyInstallmentByID($id)
    {
        //monthly installment collection bar chart
        $dataArray = Installment::where('collected_by_id',$id)->selectRaw('year(date_of_payment) year, monthname(date_of_payment) month, sum(amount_paid) installments')
            ->where("date_of_payment", ">", \Illuminate\Support\Carbon::now()->subMonths(13))
            ->groupBy('year', 'month')
            ->orderBy('date_of_payment', 'DESC')
            ->get();
        $month_name_array = array();
        $monthly_order_count_array = array();
        if ($dataArray->count() != 0) {
            foreach ($dataArray as $data) {
                $unformated_date = $data->month . '-' . $data->year;
                $date = new \DateTime($unformated_date);
                $month_name = $date->format('M-y');
                array_push($month_name_array, $month_name);
                array_push($monthly_order_count_array, $data->installments);
            }
        }

        $monthly_order_data_array = array(
            'months' => $month_name_array,
            'installment' => $monthly_order_count_array,
        );

//        return $monthly_order_data_array;
        //monthly admin fee collection bar chart
        $dataAdminArray = AdminFee::where('collected_by_id',$id)->selectRaw('year(collection_date) year, monthname(collection_date) month, sum(admin_fee_amount) fees')
            ->where("collection_date", ">", \Illuminate\Support\Carbon::now()->subMonths(13))
            ->groupBy('year', 'month')
            ->orderBy('collection_date', 'DESC')
            ->get();

//        return $dataAdminArray;
        $admin_month_name_array = array();
        $monthly_admin_count_array = array();
        if ($dataAdminArray->count() != 0) {
            foreach ($dataAdminArray as $data) {
                $unformated_date = $data->month . '-' . $data->year;
                $date = new \DateTime($unformated_date);
                $month_name = $date->format('M-y');
                array_push($admin_month_name_array, $month_name);
                array_push($monthly_admin_count_array, $data->fees);
            }
        }

        $monthly_admin_data_array = array(
            'months' => $admin_month_name_array,
            'admin' => $monthly_admin_count_array,
        );


//        return $monthly_admin_data_array;
        $employee = User::find($id);
        return view('admin.reports.monthly_installment',compact('monthly_order_data_array','monthly_admin_data_array','employee'));
    }
}


