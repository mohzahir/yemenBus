@extends('layouts.admin')

@section('content_header')
    @if (Session::has('message'))
        <div class="alert alert-{{ Session::get('type', 'warning') }}">
            {{ Session::get('message') }}
        </div>
    @endif
    <h1>اعدادت عامة</h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " >
        <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">اعدادات عامة</li>
  </ol>
</nav>
            <h1 style ="text-align:center"><h1>اعدادات عامة</h1>
        @include('flash-message')
        <form action="{{ route('dashboard.admin.general.setting.store') }}" method="POST" class="@if (count($errors)) was-validated @endif">
            @csrf

            
            <div class="form-group">
                <label for="BUS_RS_DEPOSIT_VALUE">قيمة العربون لرحلات الباص بالريال السعودي</label>
                <input type="number" class="form-control" name="BUS_RS_DEPOSIT_VALUE" value="{{ \App\Setting::where('key', 'BUS_RS_DEPOSIT_VALUE')->first()->value }}" required>
                @error('BUS_RS_DEPOSIT_VALUE')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="BUS_RY_DEPOSIT_VALUE">قيمة العربون لرحلات الباص بالريال اليمني</label>
                <input type="number" class="form-control" name="BUS_RY_DEPOSIT_VALUE" value="{{ \App\Setting::where('key', 'BUS_RY_DEPOSIT_VALUE')->first()->value }}" required>
                @error('BUS_RY_DEPOSIT_VALUE')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="HAJ_PROGRAM_RS_DEPOSIT">قيمة العربون لبرامج الحج</label>
                <input type="number" class="form-control" name="HAJ_PROGRAM_RS_DEPOSIT" value="{{ \App\Setting::where('key', 'HAJ_PROGRAM_RS_DEPOSIT')->first()->value }}" required>
                @error('HAJ_PROGRAM_RS_DEPOSIT')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="OMRA_PROGRAM_RS_DEPOSIT">قيمة العربون لبرامج العمرة</label>
                <input type="number" class="form-control" name="OMRA_PROGRAM_RS_DEPOSIT" value="{{ \App\Setting::where('key', 'OMRA_PROGRAM_RS_DEPOSIT')->first()->value }}" required>
                @error('OMRA_PROGRAM_RS_DEPOSIT')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="HAJ_SERVICE_RS_PRICE">رسوم الخدمات لبرامج الحج</label>
                <input type="number" class="form-control" name="HAJ_SERVICE_RS_PRICE" value="{{ \App\Setting::where('key', 'HAJ_SERVICE_RS_PRICE')->first()->value }}" required>
                @error('HAJ_SERVICE_RS_PRICE')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="OMRA_SERVICE_RS_PRICE">رسوم الخدمات لبرامج العمرة</label>
                <input type="number" class="form-control" name="OMRA_SERVICE_RS_PRICE" value="{{ \App\Setting::where('key', 'OMRA_SERVICE_RS_PRICE')->first()->value }}" required>
                @error('OMRA_SERVICE_RS_PRICE')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="BANK_ACCOUNT">رقم الحساب للتحويلات المالية</label>
                <input type="number" class="form-control" name="BANK_ACCOUNT" value="{{ \App\Setting::where('key', 'BANK_ACCOUNT')->first()->value }}" required>
                @error('BANK_ACCOUNT')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="BANK_ACCOUNT">وصف خدمة التحويل البنكي</label>
                <textarea rows="3" class="form-control" name="BANK_TRANSFER_SERVICE_DESCRIPTION" required>{{ \App\Setting::where('key', 'BANK_TRANSFER_SERVICE_DESCRIPTION')->first()->value }}</textarea>
                @error('BANK_TRANSFER_SERVICE_DESCRIPTION')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="BANK_ACCOUNT">وصف خدمة الدفع عند الاستلام</label>
                <textarea rows="3" class="form-control" name="ON_DELIVERY_PAYMENT_SERVICE_DESCRIPTION" required>{{ \App\Setting::where('key', 'ON_DELIVERY_PAYMENT_SERVICE_DESCRIPTION')->first()->value }}</textarea>
                @error('ON_DELIVERY_PAYMENT_SERVICE_DESCRIPTION')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="BANK_ACCOUNT">وصف خدمة الدفع عبر صديق</label>
                <textarea rows="3" class="form-control" name="PAYMENT_WITH_FRIEND_SERVICE_DESCRIPTION" required>{{ \App\Setting::where('key', 'PAYMENT_WITH_FRIEND_SERVICE_DESCRIPTION')->first()->value }}</textarea>
                @error('PAYMENT_WITH_FRIEND_SERVICE_DESCRIPTION')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="BANK_ACCOUNT">محتوى صفخة الشروط والاحكام</label>
                <textarea rows="8" class="form-control" name="PRIVACY_PAGE_CONTENT" required>{{ \App\Setting::where('key', 'PRIVACY_PAGE_CONTENT')->first()->value }}</textarea>
                @error('PRIVACY_PAGE_CONTENT')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button class="btn btn-success" type="submit">تحديث</button>
        </form>
    </div>
@stop
