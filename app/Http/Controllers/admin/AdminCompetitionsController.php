<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Competition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCompetitionsController extends Controller
{
    public function index()
    {
        $competitions = Competition::where('finish_at', '>', now()->tz('UTC')->subDay())->orderby('id','desc')->get();
        return view('dashboard.competitions.index', [
            'competitions' => $competitions
        ]);
    }

    public function show(Competition $competition)
    {
        return  view('dashboard.competitions.show', compact('competition'));
    }

    public function create()
    {
        return view('dashboard.competitions.create');
    }

    public function store()
    {
      
        $attributes = request()->validate([
            /* 'type' => ['required', 'string', Rule::in(['free', 'discount'])], */
            'old_ticket_price' => ['required', 'min:1'],
            'discount_percentage' => [/* Rule::requiredIf(request('type') == 'discount') */ 'required', 'integer', 'min:1', 'max:100'],
            /* 'week' => ['required', 'date'], */
            'available_tickets' => ['required', 'numeric'],
            'trip_at' => ['required', 'date'],
            'direction' => ['required'],
            'finish_at' => ['required', 'date', 'before_or_equal:' . request('trip_at')],
            'starting_place' => ['required', 'string'],
            'finishing_place' => ['required', 'string'],
            'booking_link' => ['required', 'url'],
            'phone_country' => ['required', Rule::in(['966', '967'])],
            'result_phone' => ['required'],
            'sponsor' => ['string', 'required'],
            'sponsor_url' => ['url'],
            'transportation_company' => ['string'],
            'transportation_company_url' => ['url'],
            'terms' => ['string'],
            'transportation_company_banner' => ['image'],
            'sponsor_banner' => ['image'],
            //'banner' => ['image'],
        ]);

        if (request()->has('sponsor_banner')) {
            if (request()->hasFile('sponsor_banner')) {
                $file = request()->file('sponsor_banner')->store('banners/sponsors');
                $attributes['sponsor_banner'] = 'storage/app/' . $file;
            }
            else {
                $attributes['sponsor_banner'] = request('sponsor_banner');
            }
        }
        if (request()->has('transportation_company_banner')) {
            if (request()->hasFile('transportation_company_banner')) {
                $file = request()->file('transportation_company_banner')->store('banners/transportation-companies');
                $attributes['transportation_company_banner'] = 'storage/app/' . $file;
            }
            else {
                $attributes['transportation_company_banner'] = request('transportation_company_banner');
            }
        }
       
        $attributes['day'] = Carbon::createFromFormat('Y-m-d H:i', request('trip_at'), 'Asia/Aden')->dayOfWeek;
    
        $date = Carbon::createFromFormat('Y-m-d H:i', request('trip_at'), 'Asia/Aden');
        $attributes['trip_at'] = $date->tz('UTC')->format('Y-m-d H:i');

        $date = Carbon::createFromFormat('Y-m-d H:i', request('finish_at'), 'Asia/Aden');
        $attributes['finish_at'] = $date->tz('UTC')->format('Y-m-d H:i');

        /* $BASE_YEAR = 2020;

        $week = Carbon::createFromFormat('Y-m-d', request('week'));
        $attributes['week'] = ($week->year - $BASE_YEAR + 1) * $week->weekOfYear; */

        // Another way: Make date intervals and check for overlap. if overlapped, then the user has registered already.

        $attributes['result_phone'] = request('phone_country') . request('result_phone');
        unset($attributes['phone_country']);
        Competition::create($attributes);

        return redirect()->route('dashboard.competitions.index')->with('message', 'تم إضافة القرعة بنجاح')->with('type', 'success');
    }

    public function edit(Competition $competition)
    {
        return view('dashboard.competitions.edit', compact('competition'));
    }

    public function update(Competition $competition)
    {
        $attributes = request()->validate([
            /* 'type' => ['required', 'string', Rule::in(['free', 'discount'])], */
            'old_ticket_price' => ['required', 'min:1'],
            'discount_percentage' => [/* Rule::requiredIf(request('type') == 'discount') */ 'required', 'integer', 'min:1', 'max:100'],
            /* 'week' => ['required', 'date'], */
            'available_tickets' => ['required', 'numeric'],
            'trip_at' => ['date_format:Y-m-d H:i'],
            'direction' => ['required'],
            'finish_at' => ['date_format:Y-m-d H:i', 'before_or_equal:' . request('trip_at')],
            'starting_place' => ['required', 'string'],
            'finishing_place' => ['required', 'string'],
            'booking_link' => ['required', 'url'],
            'phone_country' => ['required', Rule::in(['966', '967'])],
            'result_phone' => ['required'],
            'sponsor' => ['string', 'required'],
            'sponsor_url' => ['url'],
            'transportation_company' => ['string'],
            'transportation_company_url' => ['url'],
            'terms' => ['string'],
            'transportation_company_banner' => ['image'],
            'sponsor_banner' => ['image'],
            //'banner' => ['image'],
        ]);

        if (request()->has('sponsor_banner')) {
            if (request()->hasFile('sponsor_banner')) {
                $file = request()->file('sponsor_banner')->store('banners/sponsors');
                $attributes['sponsor_banner'] = 'storage/app/' . $file;
            }
            else {
                $attributes['sponsor_banner'] = request('sponsor_banner');
            }
        }
        if (request()->has('transportation_company_banner')) {
            if (request()->hasFile('transportation_company_banner')) {
                $file = request()->file('transportation_company_banner')->store('banners/transportation-companies');
                $attributes['transportation_company_banner'] = 'storage/app/' . $file;
            }
            else {
                $attributes['transportation_company_banner'] = request('transportation_company_banner');
            }
        }

        $attributes['day'] = Carbon::createFromFormat('Y-m-d H:i', request('trip_at'), 'Asia/Aden')->dayOfWeek;
        $date = Carbon::createFromFormat('Y-m-d H:i', request('trip_at'), 'Asia/Aden');
        $attributes['trip_at'] = $date->tz('UTC')->format('Y-m-d H:i');

        $date = Carbon::createFromFormat('Y-m-d H:i', request('finish_at'), 'Asia/Aden');
        $attributes['finish_at'] = $date->tz('UTC')->format('Y-m-d H:i');



       



        $attributes['result_phone'] = request('phone_country') . request('result_phone');
        unset($attributes['phone_country']);
        $competition->update($attributes);

        return redirect()->route('dashboard.competitions.index')->with('success', 'تم تعديل القرعة بنجاح')->with('type', 'success');
    }

    public function destroy(Competition $competition)
    {
        $competition->delete();

        return redirect()->route('dashboard.competitions.index')->with('message', 'تم حذف القرعة بنجاح')->with('type', 'success');
    }
}
