@extends('layouts.sweetfirst')

@section('content')

    <form action="/trapp/villa/reserveverify/{{$data}}" method="post">
        {{ csrf_field() }}
        <input type="submit" value="پرداخت"/>

    </form>
@endsection
