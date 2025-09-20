<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Client;
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
            $pdg_case_status = Cases::where('current_status', 'PDG')->get()->count('current_status');
            $opn_case_status = Cases::where('current_status', 'OPN')->get()->count('current_status');
            $fld_case_status = Cases::where('current_status', 'FLD')->get()->count('current_status');
            $dsp_case_status = Cases::where('current_status', 'DSP')->get()->count('current_status');
            $inv_case_status = Cases::where('current_status', 'INV')->get()->count('current_status');
            $ngd_case_status = Cases::where('current_status', 'NGD')->get()->count('current_status');
            $ins_case_status = Cases::where('current_status', 'INS')->get()->count('current_status');
            $fst_case_status = Cases::where('current_status', 'FST')->get()->count('current_status');
            $pst_case_status = Cases::where('current_status', 'PST')->get()->count('current_status');
            $ohc_case_status = Cases::where('current_status', 'OHC')->get()->count('current_status');
            $ohm_case_status = Cases::where('current_status', 'OHM')->get()->count('current_status');
            $cst_case_status = Cases::where('current_status', 'CST')->get()->count('current_status');
            $afc_case_status = Cases::where('current_status', 'AFC')->get()->count('current_status');
            $ult_case_status = Cases::where('current_status', 'ULT')->get()->count('current_status');

            if(Auth::user()->user_type == User::USER_TYPE_EMPLOYEE){
                $pdg_case_status = Cases::where('current_status', 'PDG')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $opn_case_status = Cases::where('current_status', 'OPN')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $fld_case_status = Cases::where('current_status', 'FLD')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $dsp_case_status = Cases::where('current_status', 'DSP')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $inv_case_status = Cases::where('current_status', 'INV')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $ngd_case_status = Cases::where('current_status', 'NGD')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $ins_case_status = Cases::where('current_status', 'INS')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $fst_case_status = Cases::where('current_status', 'FST')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $pst_case_status = Cases::where('current_status', 'PST')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $ohc_case_status = Cases::where('current_status', 'OHC')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $ohm_case_status = Cases::where('current_status', 'OHM')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $cst_case_status = Cases::where('current_status', 'CST')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $afc_case_status = Cases::where('current_status', 'AFC')->where('assigned_to_id',Auth::id())->get()->count('current_status');
                $ult_case_status = Cases::where('current_status', 'ULT')->where('assigned_to_id',Auth::id())->get()->count('current_status');
            }
            return view('admin.dashboard.index', compact('case_number', 'total_amount_owed', 'total_admin_fee', 'total_amount_balance', 'total_amount_paid', 'pdg_case_status', 'opn_case_status', 'fld_case_status', 'dsp_case_status', 'inv_case_status', 'ngd_case_status', 'ins_case_status', 'fst_case_status', 'pst_case_status', 'ohc_case_status', 'ohm_case_status', 'cst_case_status', 'afc_case_status', 'ult_case_status'));
        } else {
            $client = Client::where('user_id', Auth::id())->first();
            $cases = Cases::where('client_id', Auth::id())->get();
            $total_cases = Cases::where('client_id', Auth::id())->get()->count();
            $open_cases = Cases::where('client_id', Auth::id())->where('current_status', 'OPN')->get()->count();
            $pending_cases = Cases::where('client_id', Auth::id())->where('current_status', 'PDG')->get()->count();
            $close_cases = Cases::where('client_id', Auth::id())->where('current_status', 'CLS')->get()->count();
            return view('client.dashboard.index', compact('client', 'cases', 'total_cases', 'open_cases', 'pending_cases', 'close_cases'));
        }
    }
}
