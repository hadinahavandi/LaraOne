@extends('layouts.mobile')

@section('content')
    <div style="text-align: center;direction: rtl">
        <img src="/img/trappLogo.png" style="width: 70%"/>
        <div style="text-align: center;width: 100%;">
            {{$reserver->name}} عزیز
            <h1 style="width:100%">{{$message}}</h1>
            شما می توانید اطلاعات رزرو ویلا را در بخش رزروها در نرم افزار مشاهده نمایید.
            <div style="width: 100%;
clear:both;
margin-bottom: 10px;
margin-top: 15px;"><a href='trapp://list' style='
        background: #3ad23e;
color:#ffffff;
padding:15px 50px 15px 50px;
border-radius: 15px;
text-decoration: none;
min-width: 40%;
'
                >بازگشت به ترپ</a></div>

        </div>

        <img src="/img/trappText.png" style="margin-top: 10px;width: 70%"/>
    </div>
@endsection
