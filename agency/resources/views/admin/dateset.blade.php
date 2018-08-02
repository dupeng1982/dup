@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/calendar/dist/fullcalendar.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Icon</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Icon</li>
        </ol>
    </div>
@endsection

@section('admin-content')
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-muted">上下班时间设置</h4>
                    <label class="m-t-40">上班时间设置</label>
                    <div class="input-group clockpicker " data-placement="bottom" data-align="top"
                         data-autoclose="true">
                        <input type="text" class="form-control" value="13:14"> <span class="input-group-addon"> <span
                                    class="fa fa-clock-o"></span> </span>
                    </div>
                    <label class="m-t-40">下班时间设置</label>
                    <div class="input-group clockpicker " data-placement="bottom" data-align="top"
                         data-autoclose="true">
                        <input type="text" class="form-control" value="13:14"> <span class="input-group-addon"> <span
                                    class="fa fa-clock-o"></span> </span>
                    </div>
                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary">
                        提交
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-muted">休假日期设置</h4>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('admin/assets/plugins/calendar/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/toast-master/js/jquery.toast.js') }}"></script>
    <script src='{{ asset('admin/assets/plugins/calendar/dist/fullcalendar.min.js') }}'></script>
    <script src="{{ asset('admin/assets/plugins/calendar/dist/cal-set.js') }}"></script>
@endsection