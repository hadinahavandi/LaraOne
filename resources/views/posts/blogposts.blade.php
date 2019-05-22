@extends('layouts.sweetfirst')

@section('content')

    <?php $i = 0; ?>
    @foreach($data as $dataItem)
        <?php $i++; ?>

        <div class="col-lg-12">
            <div class="tm-activity-block">
                <div class="tm-activity-img-container">
                    <img src="/{{$dataItem->thumbnail_flu}}" alt="Image" class="tm-activity-img" />
                </div>
                <div class="tm-activity-block-text">
                    <h3 class="tm-text-blue"><a href="/posts/post{{$dataItem->id}}">{{$dataItem->title}}</a></h3>
                    {!!$dataItem->summary_te!!}
                </div>
            </div>
        </div>

    @endforeach
    <div class="pagination">
    <?php $pg = 0; ?>
    @for($pg=0;$pg<$pageCount;$pg++)
        <div><a href="/posts/{{$pg+1}}">{{$pg+1}}</a> </div>
    @endfor
    </div>
@endsection
