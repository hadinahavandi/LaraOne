@extends('layouts.sweetfirst')
@section('content')
        <div class="col-lg-12">
            <div class="tm-activity-block">
                <div class="tm-activity-img-container">
                    <img src="/{{$dataItem->thumbnail_flu}}" alt="Image" class="tm-activity-img" />
                </div>
                <div class="tm-activity-block-text">
                    <h3 class="tm-text-blue"><a href="/posts/post{{$dataItem->id}}">{{$dataItem->title}}</a></h3>
                    {!!$dataItem->content_te!!}
                </div>
            </div>
        </div>
@endsection
