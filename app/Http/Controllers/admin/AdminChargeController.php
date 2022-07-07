<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Recharge;
use App\Marketer;
use App\User;

class AdminChargeController extends Controller
{
  public function chargeForm($id = null)
  {
    //$this->authorize(User::class);
    if ($id) {
      $marketer = Marketer::where('id', $id)->first();

      return view('dashboard.marketers.charge')->with('marketer', $marketer);
    } else {
      return view('dashboard.marketers.charge');
    }
  }
  public function charge(Request $request)
  {
    $request->validate([
      'marketer_id' => 'numeric|required|exists:marketers,id',
      'amount' => 'numeric|required',
    ]);
    $m = Marketer::where('id', $request->marketer_id)->first();

    $file = null;
    if ($request->hasFile('transfer_img')) {
      $file = $request->file('transfer_img')->store('files', 'public_folder');
    }
    $recharge = Recharge::create([
      // 'code' => $request->code,
      'amount' => $request->amount,
      'notes' => $request->notes,
      'currecny' => $request->currecny,
      'transfer_img' => $file,
      'marketer_id' => $m->id,
    ]);

    if ($recharge->currecny == 'rs') {
      $m->balance_rs = $m->balance_rs + $recharge->amount;
      $m->save();
    } else {
      $m->balance_ry = $m->balance_ry + $recharge->amount;
      $m->save();
    }

    session()->flash('success', 'تم شحن رصيد المسوق بنجاح ');
    return redirect()->route('dashboard.marketers.index');
  }
}
