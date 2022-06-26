<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        return view("form");
    }

    public function post(Request $request)
    {

        $request->validate([
            "mob"         => ["required", "regex:((^(00967|967|\+967|7)([0-9]{8})$)|(^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$))"],
            "daynumber"   => "required",
            "monthnumber" => "required",
            "day"         => "required",
            "fromcity"    => "required",
            "tocity"      => "required",
            "tickets"     => "required",
            "notes"       => "nullable|max:140",
            "mmob"        => ["nullable", "regex:((^(00967|967|\+967|7)([0-9]{8})$)|(^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$))"],
        ], [
            "notes.max" => "الملاحظات يجب أن تكون حد أقصى 140 حرف.",
        ]);

        $data_array = [
            __("validation.attributes.mob")         => sanitize($request->mob),
            __("validation.attributes.tname")       => sanitize($request->tname),
            __("validation.attributes.daynumber")   => sanitize($request->daynumber),
            __("validation.attributes.monthnumber") => sanitize($request->monthnumber),
            __("validation.attributes.day")         => sanitize($request->day),
            __("validation.attributes.fromcity")    => sanitize($request->fromcity),
            __("validation.attributes.tocity")      => sanitize($request->tocity),
            __("validation.attributes.company")     => sanitize($request->company),
            __("validation.attributes.totalprice")  => sanitize($request->totalprice),
            __("validation.attributes.recamount")   => sanitize($request->recamount),
            __("validation.attributes.currency")    => sanitize($request->currency),
            __("validation.attributes.remamount")   => sanitize($request->remamount),
            __("validation.attributes.tickets")     => sanitize($request->tickets),
            __("validation.attributes.notes")       => sanitize($request->notes),
            __("validation.attributes.mname")       => sanitize($request->mname),
            __("validation.attributes.mmob")        => sanitize($request->mmob),
            __("validation.attributes.ncode")       => sanitize($request->ncode),
            __("validation.attributes.thecity")     => sanitize($request->thecity),
        ];

        try {

            if ($this->sendMail($data_array)) {
                return back()->with("success", "تم إرسال طلبك بنجاح , سوف يتم الرد عليك خلال 2 ساعة عمل .");
            } else {
                throw new Exception;
            }

        } catch (\Throwable$th) {
            return back()->with("error", "يوجد خطأ في إرسال البريد الإلكتروني.<br>ربما يوجد خطأ في PHP Mail.");
        }

    }

    private function sendMail($data_arr)
    {
        $to      = 'yemenbus1@gmail.com';
        $subject = 'حجز تذكرة يمن باص';
        $msg     = '<html><head><title>' . $subject . '</title></head><body>';
        foreach ($data_arr as $key => $val) {
            $msg .= "<p>" . $key . ": </p><p><b>" . $val . "</b></p>";
        }
        $msg .= '</body></html>';
        $headers   = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
        $params    = "";
        return mail($to, $subject, $msg, implode("\r\n", $headers), $params);
    }
}
