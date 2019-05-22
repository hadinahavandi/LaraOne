@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Manage Category</div>

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
