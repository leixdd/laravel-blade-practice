<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $acc = Account::where('user_id', Auth::user()->id)->first();
        $acc = collect(($acc ?? []))->toArray();

        $cc =  compact('barangays', 'acc');
        return view('account.index', $cc);
    }

    public function save(Request $request)
    {
        $v = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'contact_number' => 'required|numeric',
            'barangay' => 'required',
            'birthdate' => 'required|date'
        ]);

        if ($v->fails()) {
            return redirect()->back()->with('success', false)->withErrors($v)->withInput();
        }


        $acc_ = Account::where('user_id', Auth::user()->id)->first();
        $acc = false;
        if (!$acc_) {
            $acc = Account::create([
                'firstname' => $request->first_name,
                'lastname' =>  $request->last_name,
                'middlename' =>  $request->middle_name,
                'contact_number' =>  $request->contact_number,
                'birthdate' => $request->birthdate,
                'barangay_id' =>  $request->barangay,
                'user_id' => Auth::user()->id
            ]);
        } else {
            $acc = Account::where('id', $acc_->id)->update([
                'firstname' => $request->first_name,
                'lastname' =>  $request->last_name,
                'middlename' =>  $request->middle_name,
                'contact_number' =>  $request->contact_number,
                'birthdate' => $request->birthdate,
                'barangay_id' =>  $request->barangay
            ]);
        }


        if ($acc) {
            return response()->redirectToRoute('account')->with('success', true);
        }


        return response()->redirectToRoute('account')->with('success', false)->withInput();
    }
}
