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
                           data-page-size="7">
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
                        <thead>
                        <tr>
                            <th>角色标识</th>
                            <th>角色名称</th>
                            <th>角色描述</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['admin_roles'] as $key)
                            <tr>
                                <td>{{ $key->name }}</td>
                                <td>{{ $key->display_name }}</td>
                                <td>{{ $key->description }}</td>
                                <td>{{ $key->created_at }}</td>
                                <td>{{ $key->updated_at }}</td>
                                <td data-adminroleid="{{ $key->id }}">
                                    <button type="button"
                                            class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn"
                                            data-toggle="tooltip" data-original-title="分配权限"><i class="ti-key"
                                                                                                aria-hidden="true"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn"
                                            data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt"
                                                                                              aria-hidden="true"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delAdminRole"
                                            data-toggle="tooltip" data-original-title="删除"><i class="ti-close"
                                                                                              aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="pull-right">
                                    {{ $data['admin_roles']->links('pagination.bootstrap-4') }}
                                </div>
                            </td>
                        </tr>
                        </tfoot>
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
            $("[data-toggle='tooltip']").tooltip();
        });

        $(".delAdminRole").click(function () {
            var admin_role_id = $(this).parent().attr('data-adminroleid');
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
    </script>
@endsection