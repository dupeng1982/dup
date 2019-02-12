@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">我的提成</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">我的提成</li>
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
                           data-page-size="7" id="project_table">
                        <div class="m-t-20">
                            <div class="row">
                                <div class="col-3">
                                    <h4>我的提成列表</h4>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <select class="custom-select form-control" id="allot-year-select">
                                            <option value="">选择年度</option>
                                            @foreach($data['allot_year'] as $v)
                                                <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <select class="custom-select form-control" id="project-type-select">
                                            <option value="">选择项目类型</option>
                                            @foreach($data['project_type'] as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <select class="custom-select form-control" id="project-profession-select">
                                            <option value="">选择专项类型</option>
                                            @foreach($data['professions'] as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <input id="demo-input-search2" type="text" placeholder="Search"
                                               autocomplete="off">
                                        <span><button id="project-search-button"
                                                      class="btn btn-info btn-search">查找</button></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/locale/bootstrap-table-zh-CN.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/moment/min/moment.min.js') }}"></script>
    <script>
        $(function () {
            $('#project_table').bootstrapTable({
                url: 'getMyExtractList',
                ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                cache: false,
                method: 'POST',
                contentType: "application/x-www-form-urlencoded",
                dataField: "data",
                pageNumber: 1,
                pagination: true,
                queryParams: function (params) {
                    return {
                        page: (params.offset / params.limit) + 1,
                        item: params.limit,
                        search: $('#demo-input-search2').val(),
                        service_id: $('#project-type-select').val(),
                        profession_id: $('#project-profession-select').val(),
                        allot_year: $('#allot-year-select').val()
                    }
                },
                sidePagination: 'server',
                pageSize: 10,//单页记录数
                pageList: [10, 15, 20],
                responseHandler: function (result) {
                    var errcode = result.code;//在此做了错误代码的判断
                    if (errcode) {
                        return;
                    }
                    return {
                        total: result.data.total,
                        data: result.data.data
                    };
                },
                columns: [{
                    field: 'SerialNumber',
                    title: '序号',
                    formatter: function (value, row, index) {
                        var pageSize = $('#project_table').bootstrapTable('getOptions').pageSize;//通过表的#id 可以得到每页多少条
                        var pageNumber = $('#project_table').bootstrapTable('getOptions').pageNumber;//通过表的#id 可以得到当前第几页
                        return pageSize * (pageNumber - 1) + index + 1;
                    }
                }, {
                    field: 'cost_project_name',
                    title: '项目名称'
                }, {
                    field: 'number',
                    title: '专项编号'
                }, {
                    field: 'name',
                    title: '专项名称'
                }, {
                    field: 'service_name',
                    title: '项目类型'
                }, {
                    field: 'profession_name',
                    title: '专业类型'
                }, {
                    field: 'admininfo_name',
                    title: '实施人'
                }, {
                    field: 'project_allot_money',
                    title: '项目提成（万元）'
                }, {
                    field: 'check_allot_money',
                    title: '考核提成（万元）'
                }, {
                    field: 'check_result_name',
                    title: '考核状态'
                }]
            });

            function refresh() {
                $('#project_table').bootstrapTable('refresh', {url: 'getMyExtractList'});
            }

            $('#project-type-select').change(function () {
                refresh();
            });

            $('#project-search-button').click(function () {
                refresh();
            });

            $('#project-profession-select').change(function () {
                refresh();
            });

            $('#allot-year-select').change(function () {
                refresh();
            });
        })
    </script>
@endsection