<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //get list of barangays
        $barangays = Barangay::get(['id', 'barangay_name']);
        return view('account.index', compact('barangays'));
    }

    public function save(Request $request)
    {
        
    }
}
