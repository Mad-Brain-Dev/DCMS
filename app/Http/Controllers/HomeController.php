<?php

namespace App\Http\Controllers;

use App\Models\Cases;
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
        if (Auth::user()->user_type == User::USER_TYPE_ADMIN){
            $case_number = Cases::count();
            $total_amount_owed = Cases::select('total_amount_owed')->get()->sum('total_amount_owed');
            $total_amount_paid = Cases::select('total_amount_paid')->get()->sum('total_amount_paid');
            $total_amount_balance = Cases::select('total_amount_balance')->get()->sum('total_amount_balance');
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
            return view('admin.dashboard.index', compact('case_number','total_amount_owed','total_amount_balance','total_amount_paid','pdg_case_status','opn_case_status','fld_case_status','dsp_case_status','inv_case_status','ngd_case_status','ins_case_status','fst_case_status','pst_case_status','ohc_case_status','ohm_case_status','cst_case_status','afc_case_status','ult_case_status'));
        }
        else{
            return view('client.dashboard.index');
        }
    }
}
