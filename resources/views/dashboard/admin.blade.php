@extends('layouts.admin')

@section('content_header')
    @if (Session::has('message'))
        <div class="alert alert-{{ Session::get('type', 'warning') }}">
            {{ Session::get('message') }}
        </div>
    @endif
    <h1>إعدادات الأدمن</h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " >
        <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">بيانات الحساب</li>
  </ol>
</nav>
            <h1 style ="text-align:center">بيانات  الحساب</h1>

        <form action="{{ route('dashboard.admin.update') }}" method="POST" class="@if (count($errors)) was-validated @endif">
            @csrf
            <div class="form-group">
                <label for="name">الاسم</label>
                <input type="text" class="form-control" value="{{ $admin->name }}" name="name" id="name" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">الإيميل</label>
                <input type="email" class="form-control" value="{{ $admin->email }}" name="email" id="email" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input type="password" class="form-control" name="password" id="password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">إعادة تأكيد كلمة المرور</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button class="btn btn-success" type="submit">تحديث</button>
              <a class="btn btn-warning btn-close" href="">الغاء</a>
     <a class="btn btn-danger btn-close" href="{{ route('dashboard.admin.index') }}">اغلاق</a>
        </form>
    </div>
@stop
