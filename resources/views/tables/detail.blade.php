@extends('layouts.panel')

@section('title', 'Tables')

@section('css')

@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h2><span class="fa fa-table"></span> Table {{$table->name}} - {{$table->class_name}}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/tables') }}">Table List</a></li>
            <li class="active">Details for Table {{$table->name}} - {{$table->class_name}}</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="pull-left">
            <h3><span class="fa fa-list"></span> Table Detail</h3>
        </div>
        <div class="pull-right">
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target=".code-editor-modal"><span class="fa fa-file-code-o"></span> View Code</button>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".table-normalize-modal"><span class="fa fa-magic"></span> Normalize this table</button>
            <a href="{{ url('/table-remove/' . $table->name) }}" class="btn btn-danger btn-sm"><span class="fa fa-remove"></span> Remove Normalization</a>
        </div>

        <table class="table table-hover">
            <tr>
                <th><span class="fa fa-th-large"></span> Field</th>
                <th><span class="fa fa-thumbs-up"></span> Normalized attribute</th>
                <th>Type</th>
                <th>Null</th>
                <th>Key</th>
                <th>Default</th>
                <th>Extra</th>
            </tr>
            @foreach( $table->fields as $data )
                <tr>
                    <td><strong>{{$data->field_name}}@if( is_pk($data->field_key, $data->field_extra) ) <span class="fa fa-key"></span> @endif</strong></td>
                    <td><strong class="text-info">{{$data->standard_attribute}}@if( is_pk($data->field_key, $data->field_extra) ) <span class="fa fa-key"></span> @endif</strong></td>
                    <td>{{$data->field_type}}</td>
                    <td>{{$data->field_null}}</td>
                    <td>{{$data->field_key}}</td>
                    <td>{{$data->field_default}}</td>
                    <td>{{$data->field_extra}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<!-- Modal Normalization Begin -->
<form name="frm-table-normalize" id="frmTableNormalize" class="form-horizontal" action="/table-normalization/{{$table->name}}" method="post">
    {{ csrf_field() }}
    <div class="modal fade table-normalize-modal" tabindex="-1" role="dialog" aria-labelledby="tableNormalizeModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><span class="fa fa-table"></span> Normalize Table {{$table->name}} - {{$table->class_name}}</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <tr>
                            <th>Original Field</th>
                            <th>Standard attribute</th>
                        </tr>
                        @foreach($table->fields as $data)
                        <tr>
                            <td><strong><span class="fa fa-th-large"></span> {{$data->field_name}}</strong></td>
                            <td><input type="text" name="fields[{{$data->field_name}}][standard_attribute]" value="{{$data->standard_attribute}}"></td>
                            {{-- @if( is_key( $data->field_name ) != true )
                            <td><strong><span class="fa fa-th-large"></span> {{$data->field_name}}</strong></td>
                            <td><input type="text" name="fields[{{$data->field_name}}][standard_attribute]" value="{{$data->standard_attribute}}"></td>
                            @endif --}}
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-window-close"></span> Close Window</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save and generate files</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal Normalization End -->

<!-- Modal Editor Begin -->
<form name="frm-code-editor" id="frmCodeEditor" class="form-horizontal" action="/table-normalization/{{$table->name}}" method="post">
    {{ csrf_field() }}
    <div class="modal fade code-editor-modal" tabindex="-1" role="dialog" aria-labelledby="codeEditorModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><span class="fa fa-file-code-o"></span> Code Editor {{$table->name}}</h4>
                </div>
                <div class="modal-body">
                    <textarea id="txCodeEditor"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-window-close"></span> Close Window</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save code</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal Editor End -->

@endsection

@section('script')


{{-- <script type="text/javascript">
$(document).ready(function() {

});
</script> --}}
@endsection