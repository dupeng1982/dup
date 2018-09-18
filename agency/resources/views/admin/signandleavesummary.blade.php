@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
          rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">考勤汇总</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">考勤汇总</li>
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover toggle-circle"
                           data-page-size="7" id="attendance-summary-table">
                        <div class="m-t-40">
                            <div class="d-flex">
                                <h4 class="card-title">考勤汇总列表</h4>
                                <div class="ml-auto">
                                    <div class="form-group">
                                        <input id="demo-input-search2" type="text" class="datetimeStart"
                                               value="{{ Date::now()->format('Y-m') }}" autocomplete="off">
                                        <input id="demo-input-search2" type="text" placeholder="Search"
                                               class="attendance-summary-search" autocomplete="off">
                                        <span><button id="attendance-summary-search"
                                                      class="btn btn-info btn-search">查找</button></span>
                                        <span><button id="import-attendance-summary" class="btn btn-info btn-search"
                                                      onclick="event.preventDefault();
                                                      document.getElementById('import-excel-form').submit();">
                                                导出EXCEL</button></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <form id="import-excel-form" action="importMonthAttendanceSummary" method="GET"
          style="display: none;">
        @csrf
        <input type="text" value="" name="month" id="req-month">
        <input type="text" value="" name="search" id="req-search">
    </form>
@endsection

@section('admin-js')
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/locale/bootstrap-table-zh-CN.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <script>
        $(function () {
            $('#attendance-summary-table').bootstrapTable({
                url: 'getMonthAttendanceSummary',
                ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                cache: false,
                method: 'POST',
                contentType: "application/x-www-form-urlencoded",
                dataField: "data",
                pageNumber: 1,
                pagination: true,
                queryParams: queryParams,
                sidePagination: 'client',
                pageSize: 10,
                responseHandler: responseHandler,
                columns: [{
                    field: 'SerialNumber',
                    title: '序号',
                    formatter: function (value, row, index) {
                        return index + 1;
                    }
                }, {
                    field: 'realname',
                    title: '姓名'
                }, {
                    field: 'attendance_day',
                    title: '应出勤(天)'
                }, {
                    field: 'attendance_time',
                    title: '应出勤(时)'
                }, {
                    field: 'sign_day_sum',
                    title: '实出勤(天)'
                }, {
                    field: 'date_attendance_time',
                    title: '实出勤(时)'
                }, {
                    field: 'date_other_time',
                    title: '加班(时)'
                }, {
                    field: 'late_num',
                    title: '迟到(次)'
                }, {
                    field: 'left_early_num',
                    title: '早退(次)'
                }, {
                    field: 'date_leave_day',
                    title: '请假(天)'
                }, {
                    field: 'date_leave_time',
                    title: '请假(时)'
                }],
                onPostBody: onPostBody
            });
            function queryParams(params) {
                return {
                    search: $('.attendance-summary-search').val(),
                    month: $('.datetimeStart').val()
                }
            }

            function responseHandler(result) {
                var errcode = result.code;
                if (errcode) {
                    return;
                }
                return {
                    total: result.data.length,
                    data: result.data
                };
            }

            function refresh() {
                $('#attendance-summary-table').bootstrapTable('refresh', {url: 'getMonthAttendanceSummary'});
            }

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();
            }

            $('#attendance-summary-search').click(function () {
                refresh();
                $('#req-month').val($('.datetimeStart').val());
                $('#req-search').val($('.attendance-summary-search').val());
            });

            $('.datetimeStart').bootstrapMaterialDatePicker({format: 'YYYY-MM', day: false, time: false});

            $('.dtp-btn-ok').click(function () {
                refresh();
                $('#req-month').val($('.datetimeStart').val());
                $('#req-search').val($('.attendance-summary-search').val());
            });
            $('#req-month').val($('.datetimeStart').val());
            $('#req-search').val($('.attendance-summary-search').val());
        });
    </script>
@endsection