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
                           data-page-size="7" id="attendance-statistic-table">
                        <div class="m-t-40">
                            <div class="d-flex">
                                <h4 class="card-title">考勤汇总列表</h4>
                                <div class="ml-auto">
                                    <div class="form-group">
                                        <input id="demo-input-search2" type="text" class="datetimeStart"
                                               value="{{ Date::now()->format('Y-m') }}" autocomplete="off">
                                        <input id="demo-input-search2" type="text" placeholder="Search"
                                               class="attendance-statistic-search" autocomplete="off">
                                        <span><button id="attendance-statistic-search"
                                                      class="btn btn-info btn-search">查找</button></span>
                                        <span><button id="import-attendance-statistic" class="btn btn-info btn-search"
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
    <form id="import-excel-form" action="importMonthAttendanceStatistics" method="GET"
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
            $('#attendance-statistic-table').bootstrapTable({
                url: 'getMonthAttendanceStatistics',
                ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                cache: false,
                method: 'POST',
                contentType: "application/x-www-form-urlencoded",
                dataField: "data",
                pageNumber: 1,
                pagination: true,
                queryParams: queryParams,
                sidePagination: 'server',
                pageSize: 10,//单页记录数
                pageList: [10, 15, 20],
                responseHandler: responseHandler,
                columns: [{
                    field: 'SerialNumber',
                    title: '序号',
                    formatter: function (value, row, index) {
                        var pageSize = $('#attendance-statistic-table').bootstrapTable('getOptions').pageSize;//通过表的#id 可以得到每页多少条
                        var pageNumber = $('#attendance-statistic-table').bootstrapTable('getOptions').pageNumber;//通过表的#id 可以得到当前第几页
                        return pageSize * (pageNumber - 1) + index + 1;
                    }
                }, {
                    field: 'realname',
                    title: '姓名'
                }, {
                    field: 'sign_date',
                    title: '日期'
                }, {
                    field: 'sign_in_time_format',
                    title: '签到时间'
                }, {
                    field: 'sign_out_time_format',
                    title: '签退时间'
                }, {
                    field: 'leave_type_name',
                    title: '请假情况'
                }, {
                    field: 'leave_time',
                    title: '请假时间'
                }],
                onPostBody: onPostBody
            });
            function queryParams(params) {
                return {
                    page: (params.offset / params.limit) + 1,
                    item: params.limit,
                    search: $('.attendance-statistic-search').val(),
                    month: $('.datetimeStart').val()
                }
            }

            function responseHandler(result) {
                var errcode = result.code;//在此做了错误代码的判断
                if (errcode) {
                    return;
                }
                return {
                    total: result.data.total,
                    data: result.data.data
                };
            }

            function refresh() {
                $('#attendance-statistic-table').bootstrapTable('refresh', {url: 'getMonthAttendanceStatistics'});
            }

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();
            }

            $('#attendance-statistic-search').click(function () {
                refresh();
                $('#req-month').val($('.datetimeStart').val());
                $('#req-search').val($('.attendance-statistic-search').val());
            });

            $('.datetimeStart').bootstrapMaterialDatePicker({format: 'YYYY-MM', day: false, time: false});

            $('.dtp-btn-ok').click(function () {
                refresh();
                $('#req-month').val($('.datetimeStart').val());
                $('#req-search').val($('.attendance-statistic-search').val());
            });
            $('#req-month').val($('.datetimeStart').val());
            $('#req-search').val($('.attendance-statistic-search').val());
        });
    </script>
@endsection