<?php

namespace App\Http\Controllers;

use App\Models\BarangayForm;
use App\Models\BarangayFormAnswers;
use App\Models\BarangayRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $br = BarangayRequest::with('forms', 'answers');

        if(Auth::user()->userLevel === 0) {
            $br->where('user_id', Auth::user()->id);
        }


        $br = $br->simplePaginate();
        return view('requests.index', compact('br'));
    }

    public function create()
    {
        $certs = BarangayForm::get();
        return view('requests.create', compact('certs'));
    }

    public function approveRequest(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => 'required|exists:barangay_requests,id'
        ]);


        if($v->fails()) {
            return redirect()->back()->with('message', 'An error occured')->with('status', false);
        }

        if(Auth::user()->userLevel === 0) {
            return redirect()->back()->with('message', 'Access Denied')->with('status', false);
        }

        $br = BarangayRequest::where('isApproved', 0)->find($request->id);

        $br->isApproved = 1;

        $br->save();

        return redirect()->route('requests')->with('message', 'Request with a code of EF_' .  base64_encode($br->id . '_' . $br->created_at) . ' is approved')->with('status', true);
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

    public function editDocument($id)
    {
        $v = Validator::make([ 'id' => $id], [
            'id' => 'required|exists:barangay_requests,id'
        ]);


        if($v->fails()) {
            return redirect()->back()->with('message', 'An error occured')->with('status', false);
        }

        $br = BarangayRequest::with('forms', 'forms.questions')->where('user_id', Auth::user()->id)->find($id);

        if (!$br) {
            return redirect()->back()->with('message', 'Access Denied')->with('status', false);
        }

        $aw = BarangayFormAnswers::where('request_id', $id)->whereIn('barangay_form_question_id', collect($br->forms->questions)->map->only(['id'])->flatten()->all())->get();
        $answers = [];

        if($aw) {
            foreach ($aw as $a) {
                    $answers[$a->barangay_form_question_id] = $a->value;
            }
        }

        return view('requests.edit', compact('br', 'answers'));
    }

    public function viewDocument($id)
    {
        $v = Validator::make([ 'id' => $id], [
            'id' => 'required|exists:barangay_requests,id'
        ]);


        if($v->fails()) {
            return redirect()->back()->with('message', 'An error occured')->with('status', false);
        }

        $br = BarangayRequest::with('forms', 'forms.questions');

        if(Auth::user()->userLevel === 0) {
            $br->where('user_id', Auth::user()->id);
        }

        $br = $br->find($id);

        if (!$br) {
            return redirect()->back()->with('message', 'Access Denied')->with('status', false);
        }

        $aw = BarangayFormAnswers::select('barangay_form_answers.*', 'barangay_form_questions.input_order')->join('barangay_form_questions', 'barangay_form_questions.id', '=', 'barangay_form_answers.barangay_form_question_id')
            ->where('request_id', $id)
            ->whereIn('barangay_form_question_id', collect($br->forms->questions)->map->only(['id'])->flatten()->all())
            ->orderBy('barangay_form_questions.input_order', 'asc')
            ->get();

        $answers = [];

        if($aw) {
            foreach ($aw as $a) {
                $answers[$a->input_order] = $a->value;
            }
        }

        return view('pdf.' . $br->forms->blade_file ?? '' , compact('br', 'answers'));
    }

    public function updateDocument(Request $request)
    {

        $v = Validator::make($request->all(), [
            'id' => 'required|exists:barangay_requests,id'
        ]);


        if($v->fails()) {
            return redirect()->back()->with('message', 'An error occured')->with('status', false);
        }

        $inputs = $request->all();

        $br = BarangayRequest::with('forms', 'forms.questions')->where('user_id', Auth::user()->id)->find($request->id);

        if (!$br) {
            return redirect()->back()->with('message', 'Access Denied')->with('status', false);
        }

        //Save Question
        foreach ($br->forms->questions as $question) {
            if(array_key_exists($question->input_name, $inputs)) {
                $v = $inputs[$question->input_name];
                if($question->input_required === 1 && Str::of($v)->trim()->isEmpty()) {
                    return redirect()->back()->with('message', $question->input_name . ' is required')->with('status', false);
                }

                BarangayFormAnswers::updateOrCreate(
                    ['request_id' => $request->id, 'barangay_form_question_id' => $question->id],
                    ['value' => Str::of($v)->trim()]
                );
            }
        }


        return redirect()->route('requests.edit', ['id' => $request->id ])->with('message', 'Document was updated')->with('status', true);
    }

    public function viewDocQR($qr)
    {
        $id_br = explode('_', base64_decode($qr));

        return redirect()->route('requests.view', ['id' => $id_br[0]]);
    }
}
