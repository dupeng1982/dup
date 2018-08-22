@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/calendar/dist/fullcalendar.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">考勤设置</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">我的考勤</li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10 btn-themecolor">
                        <i class="ti-settings text-white"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-muted">我的考勤</h4>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('admin/assets/plugins/calendar/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/moment/moment.js') }}"></script>
    <script src='{{ asset('admin/assets/plugins/calendar/dist/fullcalendar.min.js') }}'></script>
    <script src="{{ asset('admin/assets/plugins/calendar/dist/cal-sign.js') }}"></script>
@endsection