<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Marketer;
use App\Provider;
use App\Http\Requests\NomsRequest;
use Illuminate\Support\Str;

class FinancialPermessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::guard('provider')->user()->id;
        // $pfas = DB::table('power_financial_agents')->where('provider_id', $id)->orderby('id', 'desc')->paginate(5);
        $marketers = Marketer::with('provider')->where([
            'state' => 'active',
            'provider_id' => $id,
        ])->get();
        return view('providers.financial_permession')->with(['marketers' => $marketers]);
    }
    public function noms()
    {

        $id = Auth::guard('provider')->user()->id;
        $provider = Provider::where('id', $id)->first();
        $noms = DB::table('marketers')->where('provider_id', $id)->orderby('id', 'desc')->paginate(6);


        return view('providers.nomOfMarketer')->with(['noms' => $noms]);
    }
    public function storeNoms(NomsRequest $request)
    {
        // dd($request->currency);
        request()->validate([

            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'balance' => ['required'],
            'currency' => ['required'],
            'phone' => ['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i', 'required_without:y_phone', 'nullable'],

            'y_phone' => ['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i', 'required_without:phone', 'nullable'],

        ], [
            'name.required' => ' يرجى ادخال اسم الوكيل',
            'balance.required' => ' يرجى ادخال قيمة الصلاحية المالية',
            'currency.required' => ' يرجى اختيار العملة ',
            'phone.regex' => 'الرقم غير صحيح',
            'phone.required_without' => 'يجب ادخال احد الرقمين',
            'y_phone.regex' => 'الرقم غير صحيح',
            'y_phone.required_without' => 'يجب ادخال احد الرقمين',



        ]);
        $phone = "";
        if ($request->phone) {
            $into = Str::substr($request->phone, 0, 2);

            if ($into == '05') {
                $phoneM = Str::substr($request->phone, 2, 8);

                $phone = "9665" . $phoneM;
            } else {
                $phone = $request->phone;
            }
        }
        $phoneProv = "";
        if ($request->y_phone) {
            $into = Str::substr($request->y_phone, 0, 1);

            if ($into == '7') {
                $phoneP = Str::substr($request->y_phone, 1, 8);

                $phoneProv = "9677" . $phoneP;
            } else {
                $phoneProv = $request->y_phone;
            }
        }


        DB::table('marketers')->insert(
            [
                'provider_id' => Auth::guard('provider')->user()->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'balance_rs' => $request->currency == 'rs' ? $request->balance : 0,
                'balance_ry' => $request->currency == 'ry' ? $request->balance : 0,
                'currency' => $request->currency,
                'phone' => $phone,
                'y_phone' => $phoneProv,
            ]
        );

        return redirect()->route('provider.nom.index')->with('success', 'تمت العمليه بنجاح');
    }

    public function destroyNoms($id)
    {

        DB::table('marketers')->where('id', $id)->delete();


        return redirect()->route('provider.nom.index')->with('success', 'تم الحذف بنجاح');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([

            'marketer_id' => ['required'],
            'agent_value' => ['required'],
            'agent_currency' => ['required'],

        ], [
            'code.required' => ' يرجى ادخال اسم الوكيل',
            'agent_value.required' => ' يرجى ادخال قيمة الصلاحية المالية',
            'agent_currency.required' => ' يرجى اختيار العملة ',



        ]);

        $marketer = Marketer::where('id', $request->marketer_id)->first();
        $balance_column = $request->agent_currency == 'rs' ? 'balance_rs' : 'balance_ry';
        DB::table('marketers')->update(
            [
                $balance_column => ($marketer[$balance_column] + $request->agent_value)
            ]
        );
        return  back()->with('success', 'تم اضافة بنجاح');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('power_financial_agents')->where('id', $id)->delete();
        return  back()->with('success', 'تم الحذف بنجاح');
    }
}
