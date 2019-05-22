@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Manage Context</div>

                    <div class="card-body">
                        <form action="" method="post">
                            {{csrf_field()}}
                            <div class="form-group has-feedback has-success">
                                <label id="FormLabel" class="control-label col-sm-2" for="title">title</label>
                                <div class="col-sm-10">
                                    <input name="title" value="@if($data!=null){{$data->title}} @endif" id="title"
                                           class="form-control" placeholder="title" type="text"/>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-success">
                                <label id="FormLabel" class="control-label col-sm-2" for="url">url</label>
                                <div class="col-sm-10">
                                    <input name="url" value="@if($data!=null){{$data->url}} @endif" id="url"
                                           class="form-control" placeholder="url" type="text"/>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-success">
                                <label id="FormLabel" class="control-label col-sm-2" for="description">description</label>
                                <div class="col-sm-10">
                                    <input name="description" value="@if($data!=null){{$data->description}} @endif" id="description"
                                           class="form-control" placeholder="description" type="text"/>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-success">
                                <label id="FormLabel" class="control-label col-sm-2" for="context">context</label>
                                <div class="col-sm-10">
                                    <textarea name="context" id="context"
                                           class="form-control" placeholder="context" type="text" rows="30">
                                        @if($data!=null){{$data->context}} @endif
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-success">
                                <label id="FormLabel" class="control-label col-sm-2" for="category">Category</label>
                                <div class="col-sm-10">
                                    <select name="category" id="title" class="form-control">
                                        @foreach($cats as $catItem)
                                            <option value="{{$catItem->id}}">{{$catItem->title}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button name="btnnoname" value="Save" class="btn btn-primary" type="submit">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
