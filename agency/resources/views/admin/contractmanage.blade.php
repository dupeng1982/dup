@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/jquery-combo-select/combo.select.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">合同管理</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">合同管理</li>
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
                           data-page-size="7" id="contract_table">
                        <div class="m-t-20">
                            <div class="row">
                                <div class="col-7">
                                    <h4>合同列表</h4>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <select class="custom-select form-control" id="contract-type-select">
                                            <option value="">选择合同类型</option>
                                            @foreach($data['contract_type'] as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <input id="demo-input-search2" type="text" placeholder="Search"
                                               autocomplete="off">
                                        <span><button id="contract-search"
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

    <div class="modal fade show" id="addContractModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">添加合同</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="addContractForm">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>合同名称</label>
                                        <input type="text" class="form-control"
                                               id="add-contract-name"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>合同类型</label>
                                        <select class="custom-select form-control" id="add-project-unit-type">
                                            <option value="">选择类型</option>
                                            @foreach($data['contract_type'] as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>签订时间</label>
                                        <input type="date" class="form-control"
                                               id="add-contract-sign-date"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>开始时间</label>
                                        <input type="date" class="form-control"
                                               id="add-contract-start-date"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>结束时间</label>
                                        <input type="date" class="form-control"
                                               id="add-contract-end-date"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>合同项目地址</label>
                                        <input type="text" class="form-control"
                                               id="add-contract-address"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>建设单位</label>
                                        <select class="custom-select form-control"
                                                id="add-contract-construction-select">
                                            <option value="">选择建设单位</option>
                                            @foreach($data['company'] as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>联系人</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="add-contract-construction-contact">
                                        <input type="hidden" id="add-contract-construction-id">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>联系电话</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="add-contract-construction-phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>委托单位</label>
                                        <select class="custom-select form-control"
                                                id="add-contract-agency-select">
                                            <option value="">选择委托单位</option>
                                            @foreach($data['company'] as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>联系人</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="add-contract-agency-contact">
                                        <input type="hidden" id="add-contract-agency-id">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>联系电话</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="add-contract-agency-phone"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>主要内容</label>
                                        <textarea name="remark" id="add-contract-content"
                                                  rows="6" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>备注</label>
                                        <textarea name="remark" id="add-contract-remark"
                                                  rows="6" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>附件名称</label>
                                        <input type="text" class="form-control" id="add-contract-cattachment-name">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>添加附件</label>
                                        <input type="file" class="form-control" id="add-contract-cattachment-file"
                                               multiple="multiple">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label></label>
                                        <p>
                                            <button type="button" id="add-contract-cattachment-button"
                                                    class="btn waves-effect waves-light btn-rounded btn-secondary"
                                                    style="top :10px;">
                                                添加
                                            </button>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover toggle-circle"
                                           data-page-size="7" id="add-contract-cattachment-table">
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
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
    <div class="modal fade show" id="editContractModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">编辑合同</h4>
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
                                        @foreach($data['contract_type'] as $v)
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
    <div class="modal fade show" id="confirmDelContractModal" tabindex="-1" role="dialog"
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
                    <button type="button" id="del-contract-submit"
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
    <script src="{{ asset('admin/assets/plugins/jquery-combo-select/jquery.combo.select.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/moment/min/moment.min.js') }}"></script>
    <script>
        $(function () {
            var contract_id;

            $('#add-contract-construction-select').comboSelect();
            $('#add-contract-construction-select').change(function () {
                var construction_id = $(this).val();
                var construction_select = {!! $data['company'] !!};
                var construction_selected = construction_select.filter(function (e) {
                    if (e.id == construction_id) {
                    } else {
                        return null;
                    }
                    return e;
                });

                var construction_contact = construction_selected[0] ? construction_selected[0].contact : null;
                var construction_phone = construction_selected[0] ? construction_selected[0].phone : null;
                var construction_id = construction_selected[0] ? construction_selected[0].id : null;

                $('#add-contract-construction-contact').val(construction_contact);
                $('#add-contract-construction-phone').val(construction_phone);
                $('#add-contract-construction-id').val(construction_id);
            });
            $('#add-contract-agency-select').comboSelect();
            $('#add-contract-agency-select').change(function () {
                var agency_id = $(this).val();
                var agency_select = {!! $data['company'] !!};
                var agency_selected = agency_select.filter(function (e) {
                    if (e.id == agency_id) {
                    } else {
                        return null;
                    }
                    return e;
                });

                var agency_contact = agency_selected[0] ? agency_selected[0].contact : null;
                var agency_phone = agency_selected[0] ? agency_selected[0].phone : null;
                var agency_id = agency_selected[0] ? agency_selected[0].id : null;

                $('#add-contract-agency-contact').val(agency_contact);
                $('#add-contract-agency-phone').val(agency_phone);
                $('#add-contract-agency-id').val(agency_id);
            });

            $('#contract_table').bootstrapTable({
                url: 'getContractList',
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
                        contract_type: $('#contract-type-select').val()
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
                        var pageSize = $('#contract_table').bootstrapTable('getOptions').pageSize;//通过表的#id 可以得到每页多少条
                        var pageNumber = $('#contract_table').bootstrapTable('getOptions').pageNumber;//通过表的#id 可以得到当前第几页
                        return pageSize * (pageNumber - 1) + index + 1;
                    }
                }, {
                    field: 'name',
                    title: '合同名称'
                }, {
                    field: 'contract_type_name',
                    title: '合同类型'
                }, {
                    field: 'number',
                    title: '合同编号'
                }, {
                    field: 'sign_date',
                    title: '合同签订时间'
                }, {
                    field: 'construction_name',
                    title: '建设单位'
                }, {
                    field: 'agency_name',
                    title: '委托单位'
                }, {
                    field: 'id',
                    title: '操作<button type="button" id="addContract" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="添加合同"><i class="ti-user" aria-hidden="true"></i></button>',
                    formatter: function (value, row, index) {
                        return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editContract" data-project-unit-index=' + index + ' data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt" aria-hidden="true"></i></button>' +
                            '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delContract" data-contract-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                    }
                }],
                onPostBody: onPostBody
            });

            function refresh() {
                $('#contract_table').bootstrapTable('refresh', {url: 'getContractList'});
            }

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();

                $('#addContract').click(function () {
                    $('#addContractModal').modal('show');
                });

                $('.editContract').click(function () {
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

                $('.delContract').click(function () {
                    $('#confirmDelContractModal').modal('show');
                    contract_id = $(this).attr('data-contract-id');
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

            $('#del-contract-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'delContract',
                    type: 'POST',
                    data: {
                        contract_id: contract_id
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
                            $('#confirmDelContractModal').modal('hide');
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
                $("#addContractForm")[0].reset();
            }

            $('#contract-type-select').change(function () {
                refresh();
            });

            $('#contract-search').click(function () {
                refresh();
            });
            //临时附件列表
            $('#add-contract-cattachment-table').bootstrapTable({
                url: 'getCattachmentTempList',
                ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                cache: false,
                method: 'POST',
                contentType: "application/x-www-form-urlencoded",
                dataField: "data",
                pageNumber: 1,
                pagination: false,
                search: false,
                sidePagination: 'client',
                pageSize: 5,//单页记录数
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
                    title: '文件名称'
                }, {
                    field: 'mimetype',
                    title: '文件类型'
                }, {
                    field: 'id',
                    title: '操作',
                    formatter: function (value, row, index) {
                        return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn showCattachmentTemp" data-cattachment-id=' + value + ' data-toggle="tooltip" data-original-title="查看"><i class="ti-eye" aria-hidden="true"></i></button>' +
                            '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn downLoadCattachmentTemp" data-cattachment-id=' + value + ' data-toggle="tooltip" data-original-title="下载"><i class="ti-save" aria-hidden="true"></i></button>' +
                            '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delCattachmentTemp" data-cattachment-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                    }
                }],
                onPostBody: function (res) {
                    $('.delCattachmentTemp').click(function () {
                        var cattachment_id = $(this).attr('data-cattachment-id');
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: 'delCattachment',
                            type: 'POST',
                            data: {
                                cattachment_id: cattachment_id
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
                                    refresh2();
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
                    $('.showCattachmentTemp').click(function () {
                        var cattachment_id = $(this).attr('data-cattachment-id');
                        window.open('showCattachment?cattachment_id=' + cattachment_id);
                    });
                    $('.downLoadCattachmentTemp').click(function () {
                        var cattachment_id = $(this).attr('data-cattachment-id');
                        window.open('downCattachment?cattachment_id=' + cattachment_id);
                    });
                }
            });
            $('#add-contract-cattachment-button').click(function () {
                var add_contract_cattachment_name = $('#add-contract-cattachment-name').val();
                //初始化FormData对象
                var formData = new FormData();
                var file = $("#add-contract-cattachment-file").prop("files");
                var n = file.length;
                for (var i = 0; i < n; i++) {
                    formData.append("files[]", file[i]);
                }
                formData.append("cattachment_name", add_contract_cattachment_name);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'addCattachmentTemp',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
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
                            refresh2();
                            $('#add-contract-cattachment-name').val('');
                            $("#add-contract-cattachment-file").val('')
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
            function refresh2() {
                $('#add-contract-cattachment-table').bootstrapTable('refresh', {url: 'getCattachmentTempList'});
            }
        })
    </script>
@endsection