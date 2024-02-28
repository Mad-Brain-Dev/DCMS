<?php

namespace App\Http\Controllers\Admin\Agreement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
    public function index(){
        return view('admin.agreement.agreement');
    }
}
