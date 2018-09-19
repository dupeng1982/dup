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
    <div class="modal bs-example-modal-lg fade show" id="getAdminAttendanceSummary" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">考勤汇总详情</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover toggle-circle"
                           data-page-size="7" id="admin-attendance-summary">
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
                }, {
                    field: 'admin_id',
                    title: '操作',
                    formatter: operateFormatter
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

            function operateFormatter(value, row, index) {
                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn get-attendance-summary" data-admin-id=' + value + ' data-admin-realname=' + row.realname + ' data-toggle="tooltip" data-original-title="查看详情"><i class="ti-calendar" aria-hidden="true"></i></button>';
            }

            function refresh() {
                $('#attendance-summary-table').bootstrapTable('refresh', {url: 'getMonthAttendanceSummary'});
            }

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();
                $('.get-attendance-summary').click(function () {
                    var admin_id = $(this).attr('data-admin-id');
                    var now_month = $('.datetimeStart').val();
                    var admin_realname = $(this).attr('data-admin-realname');
                    $('h4[class="modal-title"]').text(now_month + '月 ' + admin_realname + ' 考勤汇总详情');
                    $('#getAdminAttendanceSummary').modal('show');

                    $('#admin-attendance-summary').bootstrapTable({
                        url: 'getAdminAttendanceSummary',
                        ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                        cache: false,
                        method: 'POST',
                        contentType: "application/x-www-form-urlencoded",
                        dataField: "data",
                        pageNumber: 1,
                        pagination: true,
                        queryParams: queryParams1,
                        sidePagination: 'client',
                        pageSize: 10,
                        responseHandler: responseHandler1,
                        columns: [{
                            field: 'SerialNumber',
                            title: '序号',
                            formatter: function (value, row, index) {
                                return index + 1;
                            }
                        }, {
                            field: 'sign_date',
                            title: '日期'
                        }, {
                            field: 'date_format',
                            title: '星期'
                        }, {
                            field: 'sign_in_time_format',
                            title: '签到时间'
                        }, {
                            field: 'sign_out_time_format',
                            title: '签退时间'
                        }, {
                            field: 'leave_type_name',
                            title: '请假类型'
                        }, {
                            field: 'leave_time_type',
                            title: '请假时间类型',
                            formatter: leaveTimeTypeFormatter
                        }, {
                            field: 'leave_time',
                            title: '请假时间'
                        }],
                        onPostBody: onPostBody
                    });
                    function queryParams1(params) {
                        return {
                            admin_id: admin_id,
                            month: now_month
                        }
                    }

                    function responseHandler1(result) {
                        var errcode = result.code;
                        if (errcode) {
                            return;
                        }
                        return {
                            total: result.data.length,
                            data: result.data
                        };
                    }

                    function leaveTimeTypeFormatter(value, row, index) {
                        if (value == 2) {
                            return '1天内';
                        } else if (value == 1) {
                            return '全天';
                        } else {
                            return null;
                        }
                    }
                });
            }

            $('#getAdminAttendanceSummary').on('hide.bs.modal', function () {
                $('#admin-attendance-summary').bootstrapTable('destroy');
            });

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