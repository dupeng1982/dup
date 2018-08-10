@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">角色管理</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">角色管理</li>
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
                    <h4 class="card-title">角色列表</h4>
                    <table class="table table-bordered table-hover toggle-circle"
                           data-page-size="7" id="admin_role_table">
                        <div class="m-t-40">
                            <div class="d-flex">
                                <div class="mr-auto">
                                    <div class="form-group">
                                        <button type="button"
                                                class="btn waves-effect waves-light btn-rounded btn-secondary"
                                                data-toggle="modal" data-target="#addRoleModal">
                                            添加角色...
                                        </button>
                                        <div class="modal fade show" id="addRoleModal" tabindex="-1" role="dialog"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">添加角色</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group">
                                                                <label>角色标识</label>
                                                                <input type="text" class="form-control"></div>
                                                            <div class="form-group">
                                                                <label>角色名称</label>
                                                                <input type="text" class="form-control"></div>
                                                            <div class="form-group">
                                                                <label>角色描述</label>
                                                                <input type="text" class="form-control"></div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">关闭
                                                        </button>
                                                        <button type="button" class="btn btn-success">添加</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-auto">
                                    <div class="form-group">
                                        <input id="demo-input-search2" type="text" placeholder="Search"
                                               autocomplete="off">
                                        <span><button class="btn btn-info btn-search">查找</button></span>
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
    <script src="{{ asset('admin/assets/plugins/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/locale/bootstrap-table-zh-CN.min.js') }}"></script>
    <script>
        $(function () {
            $('#admin_role_table').bootstrapTable({
                url: "{{ url('admin/getRole') }}",
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
                responseHandler: responseHandler,//请求数据成功后，渲染表格前的方法
                columns: [{
                    field: 'SerialNumber',
                    title: '序号',
                    formatter: function (value, row, index) {
                        var pageSize = $('#admin_role_table').bootstrapTable('getOptions').pageSize;//通过表的#id 可以得到每页多少条
                        var pageNumber = $('#admin_role_table').bootstrapTable('getOptions').pageNumber;//通过表的#id 可以得到当前第几页
                        return pageSize * (pageNumber - 1) + index + 1;
                    }
                }, {
                    field: 'name',
                    title: '角色标识'
                }, {
                    field: 'display_name',
                    title: '角色名称'
                }, {
                    field: 'description',
                    title: '角色描述'
                }, {
                    field: 'id',
                    title: '操作',
                    formatter: operateFormatter
                }],
                onPostBody: function () {
                    $("[data-toggle='tooltip']").tooltip();
                }
            });
            function queryParams(params) {
                console.log(params);
                return {
                    page: (params.offset / params.limit) + 1,
                    item: params.limit
                }
            }

            function responseHandler(result) {
                var errcode = result.code;//在此做了错误代码的判断
                if (errcode) {
                    alert("错误代码" + errcode);
                    return;
                }
                //如果没有错误则返回数据，渲染表格
                console.log(result);
                return {
                    total: result.total,
                    data: result.data
                };
            }

            function operateFormatter(value, row, index) {
                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="分配权限"><i class="ti-key" aria-hidden="true"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt" aria-hidden="true"></i></button>' +
                    '<button onmouseover="test();" type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delAdminRole" data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
            }

            function refresh() {
                $('#admin_role_table').bootstrapTable('refresh', {url: "{{ url('admin/getRole') }}"});
            }
        });
    </script>
@endsection