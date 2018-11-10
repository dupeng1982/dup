@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">项目单位管理</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">项目单位管理</li>
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
                           data-page-size="7" id="project_unit_table">
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade show" id="addProjectUnitModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">添加单位</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="addProjectUnitForm">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>单位名称</label>
                                    <input type="text" class="form-control"
                                           id="add-project-unit-name"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>单位类型</label>
                                    <select class="custom-select form-control" id="add-project-unit-type">
                                        <option value="">选择类型</option>
                                        @foreach($data['company_type'] as $v)
                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>开户行</label>
                                    <input type="text" class="form-control"
                                           id="add-project-unit-bankname"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>开户行帐号</label>
                                    <input type="text" class="form-control"
                                           id="add-project-unit-cardno"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>联系人</label>
                                    <input type="text" class="form-control"
                                           id="add-project-unit-contact"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>手机</label>
                                    <input type="text" class="form-control"
                                           id="add-project-unit-phone"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>组织机构代码</label>
                                    <input type="text" class="form-control"
                                           id="add-project-unit-orgcode"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>税号</label>
                                    <input type="text" class="form-control"
                                           id="add-project-unit-taxnumber"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="add-project-unit-submit"
                            class="btn btn-success">提交
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="editProjectUnitModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">编辑人员信息</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>单位名称</label>
                                    <input type="text" class="form-control"
                                           id="edit-project-unit-name"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>单位类型</label>
                                    <select class="custom-select form-control" id="edit-project-unit-type">
                                        <option value="">选择类型</option>
                                        @foreach($data['company_type'] as $v)
                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>开户行</label>
                                    <input type="text" class="form-control"
                                           id="edit-project-unit-bankname"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>开户行帐号</label>
                                    <input type="text" class="form-control"
                                           id="edit-project-unit-cardno"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>联系人</label>
                                    <input type="text" class="form-control"
                                           id="edit-project-unit-contact"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>手机</label>
                                    <input type="text" class="form-control"
                                           id="edit-project-unit-phone"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>组织机构代码</label>
                                    <input type="text" class="form-control"
                                           id="edit-project-unit-orgcode"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>税号</label>
                                    <input type="text" class="form-control"
                                           id="edit-project-unit-taxnumber"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="edit-project-unit-submit"
                            class="btn btn-success">提交
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="confirmDelProjectUnit" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">操作提示</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h2 class="center-block" style="margin:0px auto;display:table;">是否删除？</h2>
                    <p class="center-block" style="margin:0px auto;display:table;">删除后不能恢复!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="del-project-unit"
                            class="btn btn-success">确定
                    </button>
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
            var project_unit_id;
            $('#project_unit_table').bootstrapTable({
                url: 'getProjectUnitList',
                ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                cache: false,
                method: 'POST',
                contentType: "application/x-www-form-urlencoded",
                dataField: "data",
                pageNumber: 1,
                pagination: true,
                search: true,
                sidePagination: 'client',
                pageSize: 10,//单页记录数
                responseHandler: function (result) {
                    var errcode = result.code;
                    if (errcode) {
                        return;
                    }
                    return {
                        total: result.data.length,
                        data: result.data
                    };
                },
                columns: [{
                    field: 'SerialNumber',
                    title: '序号',
                    formatter: function (value, row, index) {
                        return index + 1;
                    }
                }, {
                    field: 'name',
                    title: '单位名称'
                }, {
                    field: 'company_type_name',
                    title: '单位类型'
                }, {
                    field: 'bankname',
                    title: '开户行'
                }, {
                    field: 'cardno',
                    title: '开户行帐号'
                }, {
                    field: 'taxnumber',
                    title: '税号'
                }, {
                    field: 'orgcode',
                    title: '组织机构代码'
                }, {
                    field: 'contact',
                    title: '联系人'
                }, {
                    field: 'phone',
                    title: '手机号码'
                }, {
                    field: 'id',
                    title: '操作<button type="button" id="addProjectUnit" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="添加单位"><i class="ti-user" aria-hidden="true"></i></button>',
                    formatter: function (value, row, index) {
                        return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editProjectUnit" data-project-unit-index=' + index + ' data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt" aria-hidden="true"></i></button>' +
                            '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delProjectUnit" data-project-unit-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                    }
                }],
                onPostBody: onPostBody
            });

            function refresh() {
                $('#project_unit_table').bootstrapTable('refresh', {url: 'getProjectUnitList'});
            }

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();

                $('#addProjectUnit').click(function () {
                    $('#addProjectUnitModal').modal('show');
                });

                $('.editProjectUnit').click(function () {
                    $('#editProjectUnitModal').modal('show');

                    var data = $('#project_unit_table').bootstrapTable('getData');
                    var index = $(this).attr('data-project-unit-index');
                    project_unit_id = data[index].id;
                    $('#edit-project-unit-name').val(data[index].name);
                    $('#edit-project-unit-type').val(data[index].type);
                    $('#edit-project-unit-bankname').val(data[index].bankname);
                    $('#edit-project-unit-taxnumber').val(data[index].taxnumber);
                    $('#edit-project-unit-cardno').val(data[index].cardno);
                    $('#edit-project-unit-orgcode').val(data[index].orgcode);
                    $('#edit-project-unit-contact').val(data[index].contact);
                    $('#edit-project-unit-phone').val(data[index].phone);
                });

                $('.delProjectUnit').click(function () {
                    $('#confirmDelProjectUnit').modal('show');
                    project_unit_id = $(this).attr('data-project-unit-id');
                });
            }

            $('#add-project-unit-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'addProjectUnit',
                    type: 'POST',
                    data: {
                        company_name: $('#add-project-unit-name').val(),
                        company_type: $('#add-project-unit-type').val(),
                        company_bankname: $('#add-project-unit-bankname').val(),
                        company_taxnumber: $('#add-project-unit-taxnumber').val(),
                        company_cardno: $('#add-project-unit-cardno').val(),
                        company_orgcode: $('#add-project-unit-orgcode').val(),
                        company_contact: $('#add-project-unit-contact').val(),
                        company_phone: $('#add-project-unit-phone').val()
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
                            $('#addProjectUnitModal').modal('hide');
                            refresh();
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

            $('#edit-project-unit-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'editProjectUnit',
                    type: 'POST',
                    data: {
                        company_id: project_unit_id,
                        company_name: $('#edit-project-unit-name').val(),
                        company_type: $('#edit-project-unit-type').val(),
                        company_bankname: $('#edit-project-unit-bankname').val(),
                        company_taxnumber: $('#edit-project-unit-taxnumber').val(),
                        company_cardno: $('#edit-project-unit-cardno').val(),
                        company_orgcode: $('#edit-project-unit-orgcode').val(),
                        company_contact: $('#edit-project-unit-contact').val(),
                        company_phone: $('#edit-project-unit-phone').val()
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
                            $('#editProjectUnitModal').modal('hide');
                            refresh();
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

            $('#del-project-unit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'delProjectUnit',
                    type: 'POST',
                    data: {
                        company_id: project_unit_id
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
                            $('#confirmDelProjectUnit').modal('hide');
                            refresh();
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

            $('#addProjectUnitModal').on('hide.bs.modal', function () {
                clearModalInput();
            });

            function clearModalInput() {
                $("#addProjectUnitForm")[0].reset();
            }
        })
    </script>
@endsection