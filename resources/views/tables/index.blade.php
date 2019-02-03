@extends('layouts.panel')

@section('title', 'Tables')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h2><span class="fa fa-table"></span> Tables</h2>
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Table List</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="pull-right">
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target=".table-normalize-modal"><span class="fa fa-magic"></span> Normalize table names</button>
            <a href="{{url('/tables-integration')}}" class="btn btn-primary btn-sm"><span class="fa fa-table"></span> Import Tables</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h3>Normalized</h3>
        <ul>
        @foreach($tables_normalized as $table)
            <li style="list-style-type: none;"><a href="/table/{{$table->name}}" class="btn btn-success btn-sm margin-bottom-5"><span class="fa fa-table"></span> {{$table->name}} - <strong>{{$table->class_name}}</strong> - {{$table->total_normalized}} of {{$table->total_fields}}</a></li>
        @endforeach
        </ul>
    </div>

    <div class="col-md-6">
        <h3>Not normalized</h3>
        @foreach($tables_not_normalized as $table)
            <a href="javascript: return false;" class="btn btn-default btn-sm margin-bottom-5"><span class="fa fa-table"></span> {{$table->name}}</a>
        @endforeach
    </div>
</div>

<!-- Modal Normalization Begin -->
<form name="frm-table-normalize" id="frmTableNormalize" class="form-horizontal" action="/tables-normalization/" method="post">
    {{ csrf_field() }}
    <div class="modal fade table-normalize-modal" tabindex="-1" role="dialog" aria-labelledby="tableNormalizeModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><span class="fa fa-table"></span> Normalize Table Names</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <tr>
                            <th>Table</th>
                            <th>Class</th>
                        </tr>
                        @foreach($tables as $table)
                            <tr>
                                <td><input type="text" class="form-control" id="table_name" name="table_name[{{$table->name}}]" value="{{$table->name}}" disabled></td>
                                <td><input type="text" class="form-control" id="class_name" name="table[{{$table->name}}]" @if( ! empty($table->class_name) ) {{' value='.$table->class_name}}  @endif></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-window-close"></span> Close Window</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal Normalization End -->

@endsection