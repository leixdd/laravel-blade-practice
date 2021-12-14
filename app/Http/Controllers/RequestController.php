<?php

namespace App\Http\Controllers;

use App\Models\BarangayForm;
use App\Models\BarangayRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $br = BarangayRequest::with('forms')->where('user_id', Auth::user()->id)->get();
        return view('requests.index', compact('br'));
    }

    public function create()
    {
        $certs = BarangayForm::get();
        return view('requests.create', compact('certs'));
    }

    public function save(Request $request)
    {
        $v = Validator::make($request->all(), [
            'form_id' => 'required|exists:barangay_forms,id'
        ]);

        if ($v->fails()) {
            return redirect()->back()->with('message', 'An error occured')->with('status', false);
        }


        $br = BarangayRequest::where('barangay_form_id', $request->form_id)
        ->where('isApproved', 0)
        ->where('user_id', Auth::user()->id)
        ->first();

        if ($br) {
            return redirect()->back()
                ->with('message', 'There was an existing request, Please check it first.')
                ->with('status', false);
        }

        $b = BarangayRequest::create([
            'barangay_form_id' => $request->form_id,
            'user_id' =>  Auth::user()->id,
            'otp' => 0,
            'isApproved' => 0
        ]);

        if (!$b) {
            return redirect()->back()->with('message', 'An error occured')->with('status', false);
        }

        return redirect()->route('requests')->with('message', 'Request with a code of EF_' .  base64_encode($b->id . '_' . $b->created_at) . ' was created')->with('status', true);
    }
}
