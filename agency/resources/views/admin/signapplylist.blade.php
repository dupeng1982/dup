@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">补签审核</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">补签审核</li>
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
                           data-page-size="7" id="sign_apply_table">
                        <div class="m-t-40">
                            <div class="d-flex">
                                <h4 class="card-title">补签申请列表</h4>
                                <div class="ml-auto">
                                    <div class="form-group">
                                        <input id="demo-input-search2" type="text" placeholder="Search"
                                               autocomplete="off">
                                        <span><button id="sign-apply-search"
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
    <div class="modal fade show" id="checkSignApplyModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">补签审核</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>审核说明</label>
                            <input type="text" class="form-control"
                                   id="add-approval-note"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="check-sign-apply-yes"
                            class="btn btn-success">通过
                    </button>
                    <button type="button" id="check-sign-apply-no"
                            class="btn btn-secondary">驳回
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/locale/bootstrap-table-zh-CN.min.js') }}"></script>
    <script>
        $(function () {
            $('#sign_apply_table').bootstrapTable({
                url: 'getSignApplyList',
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
                        var pageSize = $('#sign_apply_table').bootstrapTable('getOptions').pageSize;//通过表的#id 可以得到每页多少条
                        var pageNumber = $('#sign_apply_table').bootstrapTable('getOptions').pageNumber;//通过表的#id 可以得到当前第几页
                        return pageSize * (pageNumber - 1) + index + 1;
                    }
                }, {
                    field: 'realname',
                    title: '姓名'
                }, {
                    field: 'sign_apply_date',
                    title: '补签日期'
                }, {
                    field: 'sign_apply_type_name',
                    title: '补签类型'
                }, {
                    field: 'sign_apply_reason',
                    title: '补签原因',
                    width: '15%'
                }, {
                    field: 'submit_time',
                    title: '提交时间'
                }, {
                    field: 'approval_name',
                    title: '审核人'
                }, {
                    field: 'approval_time',
                    title: '审核时间'
                }, {
                    field: 'approval_note',
                    title: '审核备注'
                }, {
                    field: 'id',
                    title: '操作',
                    formatter: operateFormatter
                }],
                onPostBody: onPostBody
            });
            function queryParams(params) {
                return {
                    page: (params.offset / params.limit) + 1,
                    item: params.limit,
                    search: $('#demo-input-search2').val()
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

            function operateFormatter(value, row, index) {
                if (row.sign_apply_status == 2) {
                    return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn checkSignApply" data-sign-apply-id=' + value + ' data-toggle="tooltip" data-original-title="审核"><i class="ti-marker-alt" aria-hidden="true"></i></button>';
                } else if (row.sign_apply_status == 1) {
                    return '审核通过';
                } else {
                    return '驳回';
                }

            }

            function refresh() {
                $('#sign_apply_table').bootstrapTable('refresh', {url: 'getSignApplyList'});
            }

            var sign_apply_id;

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();
                $('.checkSignApply').click(function () {
                    sign_apply_id = $(this).attr('data-sign-apply-id');
                    $('#checkSignApplyModal').modal('show');
                });
            }

            $('#sign-apply-search').click(function () {
                refresh();
            });

            $('#check-sign-apply-yes').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'checkSignApply',
                    type: 'POST',
                    data: {
                        sign_apply_id: sign_apply_id,
                        approval_note: $('#add-approval-note').val(),
                        sign_apply_status: 1
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
                            $('#checkSignApplyModal').modal('hide');
                            $.toast({
                                heading: '成功',
                                text: doc.data,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 6
                            });
                            refresh()
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

            $('#check-sign-apply-no').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'checkSignApply',
                    type: 'POST',
                    data: {
                        sign_apply_id: sign_apply_id,
                        approval_note: $('#add-approval-note').val(),
                        sign_apply_status: 0
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
                            $('#checkSignApplyModal').modal('hide');
                            $.toast({
                                heading: '成功',
                                text: doc.data,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 6
                            });
                            refresh()
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
        });
    </script>
@endsection