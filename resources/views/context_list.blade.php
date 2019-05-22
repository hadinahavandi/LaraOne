@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Contexts
                        <div><a href="/tts/contexts/manage" class="btn btn-success">Add New Item</a></div>
                    </div>

                    <div class="card-body">


                        <table class="table-striped table-hover managelist">
                            <tbody>

                            <tr>
                                <th colspan="1" class="listtitle"><span id="Lable" class="Lable">#</span></th>
                                <th colspan="1" class="listtitle"><span id="Lable" class="Lable">Title</span></th>
                                <th colspan="1" class="listtitle"><span id="Lable" class="Lable">Operations</span></th>
                            </tr>
                            <?php $i = 0; ?>
                            @foreach($data as $dataItem)
                                <?php $i++; ?>

                                <tr>
                                    <td colspan="1" class="listcontent"><span id="Lable" class="Lable">{{$i}}</span>
                                    </td>
                                    <td colspan="1" class="listcontent"><a
                                                href="/tts/contexts/manage?id={{$dataItem->id}}" class="link"
                                                id="link"><span id="Lable" class="Lable">{{$dataItem->title}}</span></a>
                                    </td>
                                    <td colspan="1" class="listcontent">
                                        <div class="operationspart">
                                            <a href="/tts/contexts/delete?id={{$dataItem->id}}" class="btn btn-danger"
                                               id="link"><i class="glyphicon glyphicon-remove"></i><span id="Lable"
                                                                                                         class="Lable">Remove</span></a>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
