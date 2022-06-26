<?php

namespace App\Exports;

use App\Reseervation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReseervationExport implements FromCollection,WithHeadings

{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $code=Auth::guard('marketer')->user()->code;
        return Reseervation::where('code',$code)->get();
    }
    public function headings(): array
    {
        return [
            '#',
            'كود المسوق',
            'رقم الطلب',
            ' رابط الطلب',
            ' رقم الرحلة',
            'اسم المسافر',
            'رقم الجوال السعودي',
            'رقم الجوال  اليمني',
            ' واتساب',
            'رقم المزود',
            'مبلغ كامل',
            'مبلغ  عربون',
            'طرق  الدفع',
            ' عملة',
            ' يوم',
            ' تاريخ',
            ' حالة الحجز',
        ];
    }

}
