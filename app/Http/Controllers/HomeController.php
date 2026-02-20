<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\CaseStatus;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Installment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->user_type == User::USER_TYPE_ADMIN || Auth::user()->user_type == User::USER_TYPE_EMPLOYEE) {
            $case_number = Cases::count();
            $total_admin_fee = number_format(Client::select('admin_fee')->get()->sum('admin_fee'), 2);
            $total_amount_owed = number_format(Cases::select('total_amount_owed')->get()->sum('total_amount_owed'), 2);
            $total_amount_paid = number_format(Installment::select('amount_paid')->get()->sum('amount_paid'), 2);
            $total_amount_balance = number_format(Cases::select('total_amount_balance')->get()->sum('total_amount_balance'), 2);
            $caseStatuses = CaseStatus::all();

            $half = ceil($caseStatuses->count() / 2);

            $leftStatuses  = $caseStatuses->slice(0, $half);
            $rightStatuses = $caseStatuses->slice($half);

            $statuses = CaseStatus::pluck('short_name')->toArray();
            $statusCounts = [];

            foreach ($statuses as $code) {

                $query = Cases::where('current_status', $code);

                if (Auth::user()->user_type == User::USER_TYPE_EMPLOYEE) {
                    $employee = Employee::where('user_id',Auth::user()->id)->first();
                    $query->where('assigned_to_id',$employee->id );
                }

                $statusCounts[$code] = $query->count();
            }
            return view('admin.dashboard.index', compact('case_number','leftStatuses','rightStatuses', 'statusCounts','total_amount_owed', 'total_admin_fee', 'total_amount_balance', 'total_amount_paid'));
        } else {
            $client = Client::where('user_id', Auth::id())->first();
            $cases = Cases::where('client_id', Auth::id())->get();
            $total_cases = Cases::where('client_id', Auth::user()->client->id)->count();
            $open_cases = Cases::where('client_id', Auth::user()->client->id)->where('current_status', 'new')->get()->count();
            $pending_cases = Cases::where('client_id', Auth::user()->client->id)->where('current_status', 'PDG')->get()->count();
            $close_cases = Cases::where('client_id', Auth::user()->client->id)->where('current_status', 'CLS')->get()->count();
            return view('client.dashboard.index', compact('client', 'cases', 'total_cases', 'open_cases', 'pending_cases', 'close_cases'));
        }
    }
}
//kigudotyga@mailinator.com
