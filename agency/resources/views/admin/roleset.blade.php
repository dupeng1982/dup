@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
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
                                    </div>
                                </div>
                                <div class="ml-auto">
                                    <div class="form-group">
                                        <input id="demo-input-search2" type="text" placeholder="Search"
                                               autocomplete="off">
                                        <span><button id="role-search"
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
                            <input type="text" class="form-control"
                                   id="add-admin-role-name"></div>
                        <div class="form-group">
                            <label>角色名称</label>
                            <input type="text" class="form-control"
                                   id="add-admin-role-display-name"></div>
                        <div class="form-group">
                            <label>角色描述</label>
                            <input type="text" class="form-control"
                                   id="add-admin-role-description"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="add-admin-role"
                            class="btn btn-success">添加
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="editRoleModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">编辑角色</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>角色标识</label>
                            <input type="text" class="form-control" value=""
                                   id="edit-admin-role-name"></div>
                        <div class="form-group">
                            <label>角色名称</label>
                            <input type="text" class="form-control" value=""
                                   id="edit-admin-role-display-name"></div>
                        <div class="form-group">
                            <label>角色描述</label>
                            <input type="text" class="form-control" value=""
                                   id="edit-admin-role-description"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="edit-admin-role"
                            class="btn btn-success">修改
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bs-example-modal-lg fade show" id="PermListModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">权限分配</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover toggle-circle"
                           data-page-size="12" id="admin_perms_table"></table>
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
    <script src="{{ asset('admin/assets/plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    {{--<script src="{{ asset('admin/assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>--}}
    <script>
        $(function () {
            var admin_role_id = null;
            $('#admin_role_table').bootstrapTable({
                url: 'getRoleList',
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
                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn allotAdminPerms" data-adminroleid=' + value + ' data-toggle="tooltip" data-original-title="分配权限"><i class="ti-key" aria-hidden="true"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editAdminRole" data-adminroleindex=' + index + ' data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt" aria-hidden="true"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delAdminRole" data-adminroleid=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
            }

            function refresh() {
                $('#admin_role_table').bootstrapTable('refresh', {url: "{{ url('admin/getRoleList') }}"});
            }

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();
                $('.editAdminRole').click(function () {
                    var data = $('#admin_role_table').bootstrapTable('getData');
                    var index = $(this).attr('data-adminroleindex');
                    admin_role_id = data[index].id;
                    $('#editRoleModal').modal('show');
                    $('#edit-admin-role-name').val(data[index].name);
                    $('#edit-admin-role-display-name').val(data[index].display_name);
                    $('#edit-admin-role-description').val(data[index].description);
                });
                $(".delAdminRole").click(function () {
                    var admin_role_id = $(this).attr('data-adminroleid');
                    swal({
                            title: "是否删除？",
                            text: "删除后不能恢复!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "是",
                            cancelButtonText: "否",
                            closeOnConfirm: true
                        }, function () {
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                url: 'delRole',
                                type: 'POST',
                                data: {
                                    role_id: admin_role_id
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
                        }
                    );
                });
                $('.allotAdminPerms').click(function () {
                    $('#PermListModal').modal('show');
                    $('#admin_perms_table').bootstrapTable({
                        url: 'getAdminPerms',
                        ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                        cache: false,
                        method: 'POST',
                        contentType: "application/x-www-form-urlencoded",
                        dataField: "data",
                        pageNumber: 1,
                        pagination: true,
                        queryParams: function () {
                            return {
                                role_id: admin_role_id
                            }
                        },
                        search: true,
                        sidePagination: 'client',
                        pageSize: 2,
                        responseHandler: responseHandler1,
                        columns: [{
                            field: 'SerialNumber',
                            title: '序号',
                            formatter: function (value, row, index) {
                                return index + 1;
                            }
                        }, {
                            field: 'name',
                            title: '权限标识'
                        }, {
                            field: 'display_name',
                            title: '权限名称'
                        }, {
                            field: 'description',
                            title: '权限描述'
                        }, {
                            field: 'id',
                            title: '操作',
                            formatter: operateFormatter1
                        }],
                        onPostBody: onPostBody1
                    });

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

                    function operateFormatter1(value, row, index) {
                        if (row.prem_status) {
                            return '<input type="checkbox" checked class="allotPerms"/>';
                        } else {
                            return '<input type="checkbox" class="allotPerms"/>';
                        }
                    }

                    function onPostBody1(res) {
                        $(".allotPerms").bootstrapSwitch({
                            onText: "是",
                            offText: "否",
                            onColor: "success",
                            offColor: "info",
                            size: "small",
                            onSwitchChange: function (event, state) {
//                                if (state == true) {
//                                    cartshow_submit($(this).attr("data-estateID"), $(this).attr("data-cartShow"), 1, function (check) {
//                                        if (!check) {
//                                            alert("修改失败！");
//                                        }
//                                        location.reload();
//                                    });
//                                } else {
//                                    cartshow_submit($(this).attr("data-estateID"), $(this).attr("data-cartShow"), 0, function (check) {
//                                        if (!check) {
//                                            alert("修改失败！");
//                                        }
//                                        location.reload();
//                                    });
//                                }
                            }
                        });
                    }
                });
            }

            $('#role-search').click(function () {
                refresh();
            });

            $('#add-admin-role').click(function () {
                var admin_role_name = $('#add-admin-role-name').val();
                var admin_role_display_name = $('#add-admin-role-display-name').val();
                var admin_role_description = $('#add-admin-role-description').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'addRole',
                    type: 'POST',
                    data: {
                        role_name: admin_role_name,
                        role_display_name: admin_role_display_name,
                        role_description: admin_role_description
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
                            $('#addRoleModal').modal('hide');
                            $('#add-admin-role-name').val('');
                            $('#add-admin-role-display-name').val('');
                            $('#add-admin-role-description').val('');
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

            $('#edit-admin-role').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'editRole',
                    type: 'POST',
                    data: {
                        role_id: admin_role_id,
                        role_name: $('#edit-admin-role-name').val(),
                        role_display_name: $('#edit-admin-role-display-name').val(),
                        role_description: $('#edit-admin-role-description').val()
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
                            $('#editRoleModal').modal('hide');
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