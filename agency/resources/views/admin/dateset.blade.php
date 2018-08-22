@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/calendar/dist/fullcalendar.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">考勤设置</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">考勤设置</li>
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
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-muted">上下班时间设置（6月-9月）</h4>
                    <label class="m-t-40">上班时间设置</label>
                    <div class="input-group clockpicker " data-placement="bottom" data-align="top"
                         data-autoclose="true">
                        <input type="text" class="form-control" id="get_summer_start_time" readonly
                               value="{{ $data['time_set']->where('set_month','06')->first()->set_start_time }}"> <span
                                class="input-group-addon"> <span
                                    class="fa fa-clock-o"></span> </span>
                    </div>
                    <label class="m-t-40">下班时间设置</label>
                    <div class="input-group clockpicker " data-placement="bottom" data-align="top"
                         data-autoclose="true">
                        <input type="text" class="form-control" id="get_summer_end_time" readonly
                               value="{{ $data['time_set']->where('set_month','06')->first()->set_end_time }}"> <span
                                class="input-group-addon"> <span
                                    class="fa fa-clock-o"></span> </span>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary set_summer_time"
                            style="margin:0px auto;display:table;">
                        保存设置
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-muted">上下班时间设置（其余月份）</h4>
                    <label class="m-t-40">上班时间设置</label>
                    <div class="input-group clockpicker " data-placement="bottom" data-align="top"
                         data-autoclose="true">
                        <input type="text" class="form-control" id="get_winter_start_time" readonly
                               value="{{ $data['time_set']->where('set_month','01')->first()->set_start_time }}"> <span
                                class="input-group-addon"> <span
                                    class="fa fa-clock-o"></span> </span>
                    </div>
                    <label class="m-t-40">下班时间设置</label>
                    <div class="input-group clockpicker " data-placement="bottom" data-align="top"
                         data-autoclose="true">
                        <input type="text" class="form-control" id="get_winter_end_time" readonly
                               value="{{ $data['time_set']->where('set_month','01')->first()->set_end_time }}"> <span
                                class="input-group-addon"> <span
                                    class="fa fa-clock-o"></span> </span>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary set_winter_time"
                            style="margin:0px auto;display:table;">
                        保存设置
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
    <script src='{{ asset('admin/assets/plugins/calendar/dist/fullcalendar.min.js') }}'></script>
    <script src="{{ asset('admin/assets/plugins/calendar/dist/cal-set.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
    <script>
        $('.clockpicker').clockpicker();
        $('.set_summer_time').click(function () {
            var start_time = $('#get_summer_start_time').val();
            var end_time = $('#get_summer_end_time').val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'setSummerTime',
                type: 'POST',
                data: {
                    start_time: start_time,
                    end_time: end_time
                },
                success: function (doc) {
                    if (doc.code) {
                        $.toast({
                            heading: '警告',
                            text: doc.data,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'warning',
                            hideAfter: 3000,
                            stack: 6
                        });
                    } else {
                        $.toast({
                            heading: '成功',
                            text: doc.data,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 6
                        });
                    }
                },
                error: function (doc) {
                    $.toast({
                        heading: '错误',
                        text: '网络错误，请稍后重试！',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 3000,
                        stack: 6
                    });
                }
            });
        });
        $('.set_winter_time').click(function () {
            var start_time = $('#get_winter_start_time').val();
            var end_time = $('#get_winter_end_time').val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'setWinterTime',
                type: 'POST',
                data: {
                    start_time: start_time,
                    end_time: end_time
                },
                success: function (doc) {
                    if (doc.code) {
                        $.toast({
                            heading: '警告',
                            text: doc.data,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'warning',
                            hideAfter: 3000,
                            stack: 6
                        });
                    } else {
                        $.toast({
                            heading: '成功',
                            text: doc.data,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 6
                        });
                    }
                },
                error: function (doc) {
                    $.toast({
                        heading: '错误',
                        text: '网络错误，请稍后重试！',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 3000,
                        stack: 6
                    });
                }
            });
        });
    </script>
@endsection