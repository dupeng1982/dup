@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/jquery-combo-select/combo.select.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">造价项目管理</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">造价项目管理</li>
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
                                <div class="col-7">
                                    <h4>造价项目列表</h4>
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

    <div class="modal fade show" id="addProjectModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">添加项目</h4>
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
                                        <label>项目名称</label>
                                        <input type="text" class="form-control"
                                               id="add-contract-name"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>项目类型</label>
                                        <select class="custom-select form-control" id="add-contract-type">
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
                    <button type="button" id="add-contract-submit"
                            class="btn btn-success">提交
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="editProjectModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">编辑项目</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>合同名称</label>
                                        <input type="text" class="form-control"
                                               id="edit-contract-name"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>合同类型</label>
                                        <select class="custom-select form-control" id="edit-contract-type">
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
                                               id="edit-contract-sign-date"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>开始时间</label>
                                        <input type="date" class="form-control"
                                               id="edit-contract-start-date"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>结束时间</label>
                                        <input type="date" class="form-control"
                                               id="edit-contract-end-date"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>合同项目地址</label>
                                        <input type="text" class="form-control"
                                               id="edit-contract-address"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>建设单位</label>
                                        <select class="custom-select form-control"
                                                id="edit-contract-construction-select">
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
                                               id="edit-contract-construction-contact">
                                        <input type="hidden" id="edit-contract-construction-id">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>联系电话</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="edit-contract-construction-phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>委托单位</label>
                                        <select class="custom-select form-control"
                                                id="edit-contract-agency-select">
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
                                               id="edit-contract-agency-contact">
                                        <input type="hidden" id="edit-contract-agency-id">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>联系电话</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="edit-contract-agency-phone"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>主要内容</label>
                                        <textarea name="remark" id="edit-contract-content"
                                                  rows="6" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>备注</label>
                                        <textarea name="remark" id="edit-contract-remark"
                                                  rows="6" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>附件名称</label>
                                        <input type="text" class="form-control" id="edit-contract-cattachment-name">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>添加附件</label>
                                        <input type="file" class="form-control" id="edit-contract-cattachment-file"
                                               multiple="multiple">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label></label>
                                        <p>
                                            <button type="button" id="edit-contract-cattachment-button"
                                                    class="btn waves-effect waves-light btn-rounded btn-secondary"
                                                    style="top :10px;">
                                                添加
                                            </button>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover toggle-circle"
                                           data-page-size="7" id="edit-contract-cattachment-table">
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
                    <button type="button" id="edit-contract-submit"
                            class="btn btn-success">提交
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade show" id="editSonProjectModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">编辑子项目</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>子项目名称</label>
                                        <input type="text" class="form-control"
                                               id="edit-son-project-name"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>专业类型</label>
                                        <select class="custom-select form-control" id="edit-son-project-profession">
                                            <option value="">选择专业类型</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>备注</label>
                                        <textarea name="remark" id="edit-son-project-remark"
                                                  rows="6" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>附件名称</label>
                                        <input type="text" class="form-control" id="edit-cspattachment-name">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>添加附件</label>
                                        <input type="file" class="form-control" id="edit-cspattachment-file"
                                               multiple="multiple">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label></label>
                                        <p>
                                            <button type="button" id="edit-cspattachment-button"
                                                    class="btn waves-effect waves-light btn-rounded btn-secondary"
                                                    style="top :10px;">
                                                添加
                                            </button>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover toggle-circle"
                                           data-page-size="7" id="edit-cspattachment-table">
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
                    <button type="button" id="edit-son-project-submit"
                            class="btn btn-success">提交
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="confirmDelProjectModal" tabindex="-1" role="dialog"
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
                    <button type="button" id="del-project-submit"
                            class="btn btn-success">确定
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="confirmDelSonProjectModal" tabindex="-1" role="dialog"
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
                    <button type="button" id="del-sonproject-submit"
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
            var public_project_id;
            var public_sonproject_id;
            var public_sontable_index;

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

            $('#edit-contract-construction-select').comboSelect();
            $('#edit-contract-construction-select').change(function () {
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

                $('#edit-contract-construction-contact').val(construction_contact);
                $('#edit-contract-construction-phone').val(construction_phone);
                $('#edit-contract-construction-id').val(construction_id);
            });
            $('#edit-contract-agency-select').comboSelect();
            $('#edit-contract-agency-select').change(function () {
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

                $('#edit-contract-agency-contact').val(agency_contact);
                $('#edit-contract-agency-phone').val(agency_phone);
                $('#edit-contract-agency-id').val(agency_id);
            });

            $('#project_table').bootstrapTable({
                url: 'getCostProjectList',
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
                        service_id: $('#project-type-select').val()
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
                    field: 'number',
                    title: '项目编号'
                }, {
                    field: 'name',
                    title: '项目名称'
                }, {
                    field: 'service_name',
                    title: '项目类型'
                }, {
                    field: 'receive_date',
                    title: '收到时间'
                }, {
                    field: 'profession',
                    title: '专业类型',
                    formatter: function (value, row, index) {
                        var str = new Array();
                        if (value) {
                            for (var i = 0, len = value.length; i < len; i++) {
                                str[i] = value[i]['name'];
                            }
                            return str;
                        } else {
                            return null;
                        }
                    }
                }, {
                    field: 'cost',
                    title: '送审造价'
                }, {
                    field: 'construction_name',
                    title: '建设单位'
                }, {
                    field: 'implement_name',
                    title: '施工单位'
                }, {
                    field: 'agency_name',
                    title: '委托单位'
                }, {
                    field: 'id',
                    title: '操作<button type="button" id="addProject" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="添加项目"><i class="ti-user" aria-hidden="true"></i></button>',
                    formatter: function (value, row, index) {
                        return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn addSonProject" data-project-index=' + index + ' data-toggle="tooltip" data-original-title="添加子项目"><i class="ti-file" aria-hidden="true"></i></button>' +
                            '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editProject" data-project-index=' + index + ' data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt" aria-hidden="true"></i></button>' +
                            '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delProject" data-project-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                    }
                }],
                onPostBody: onPostBody,
                detailView: true,
                onExpandRow: function (index, row, $detail) {
                    var son_table = $detail.html('<table id="sonproject-table-' + row.id + '" class="table table-bordered table-hover toggle-circle" data-page-size="6"></table>').find('table');
                    $(son_table).bootstrapTable({
                        url: 'getCostSonProjectList',
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
                        queryParams: function (params) {
                            return {
                                project_id: row.id
                            }
                        },
                        columns: [{
                            field: 'SerialNumber',
                            title: '序号',
                            formatter: function (value, row, index) {
                                return index + 1;
                            }
                        }, {
                            field: 'number',
                            title: '子项目编号'
                        }, {
                            field: 'name',
                            title: '子项目名称'
                        }, {
                            field: 'profession_name',
                            title: '专业类型'
                        }, {
                            field: 'cost',
                            title: '送审造价'
                        }, {
                            field: 'check_cost',
                            title: '核定造价'
                        }, {
                            field: 'id',
                            title: '操作',
                            formatter: function (value, row, index) {
                                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editSonProject" data-project-id=' + row.project_id + ' data-sonproject-index=' + index + ' data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt" aria-hidden="true"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delSonProject" data-project-id=' + row.project_id + ' data-sonproject-index=' + index + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                            }
                        }],
                        onPostBody: onPostBodySon
                    });
                },
                icons: {
                    paginationSwitchDown: 'glyphicon-collapse-down icon-chevron-down',
                    paginationSwitchUp: 'glyphicon-collapse-up icon-chevron-up',
                    refresh: 'glyphicon-refresh icon-refresh',
                    toggle: 'glyphicon-list-alt icon-list-alt',
                    columns: 'glyphicon-th icon-th',
                    detailOpen: 'mdi mdi-arrow-right-drop-circle-outline',
                    detailClose: 'mdi mdi-arrow-down-drop-circle-outline'
                }
            });

            function refresh() {
                $('#project_table').bootstrapTable('refresh', {url: 'getCostProjectList'});
            }

            function sonrefresh(project_id) {
                $('#sonproject-table-' + project_id).bootstrapTable('refresh', {url: 'getCostSonProjectList'});
            }
            
            function sonattachment() {
                $('#edit-cspattachment-table').bootstrapTable('refresh', {url: 'getCspattachment'});
            }

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();

                $('#addContract').click(function () {
                    $('#addContractModal').modal('show');
                });

                $('.editContract').click(function () {
                    $('#editContractModal').modal('show');

                    var data = $('#contract_table').bootstrapTable('getData');
                    var index = $(this).attr('data-contract-index');
                    contract_id = data[index].id;
                    $('#edit-contract-name').val(data[index].name);
                    $('#edit-contract-type').val(data[index].type);
                    $('#edit-contract-address').val(data[index].address);
                    $('#edit-contract-sign-date').val(data[index].sign_date);
                    $('#edit-contract-start-date').val(data[index].start_date);
                    $('#edit-contract-end-date').val(data[index].end_date);
                    $('#edit-contract-construction-id').val(data[index].construction_id);
                    $('#edit-contract-construction-contact').val(data[index].construction_contact);
                    $('#edit-contract-construction-phone').val(data[index].construction_phone);
                    $('#edit-contract-agency-id').val(data[index].agency_id);
                    $('#edit-contract-agency-contact').val(data[index].agency_contact);
                    $('#edit-contract-agency-phone').val(data[index].agency_phone);
                    $('#edit-contract-content').val(data[index].content);
                    $('#edit-contract-remark').val(data[index].remark);
                    $('#edit-contract-construction-select').nextAll('input[type="text"]').val(data[index].construction_name);
                    $('#edit-contract-agency-select').nextAll('input[type="text"]').val(data[index].agency_name);

                    $('#edit-contract-cattachment-table').bootstrapTable({
                        url: 'getCattachmentList',
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
                        queryParams: function (params) {
                            return {
                                contract_id: contract_id
                            }
                        },
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
                                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn showCattachment" data-cattachment-id=' + value + ' data-toggle="tooltip" data-original-title="查看"><i class="ti-eye" aria-hidden="true"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn downLoadCattachment" data-cattachment-id=' + value + ' data-toggle="tooltip" data-original-title="下载"><i class="ti-save" aria-hidden="true"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delCattachment" data-cattachment-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                            }
                        }],
                        onPostBody: function (res) {
                            $('.delCattachment').click(function () {
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
                                            refresh3();
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
                            $('.showCattachment').click(function () {
                                var cattachment_id = $(this).attr('data-cattachment-id');
                                window.open('showCattachment?cattachment_id=' + cattachment_id);
                            });
                            $('.downLoadCattachment').click(function () {
                                var cattachment_id = $(this).attr('data-cattachment-id');
                                window.open('downCattachment?cattachment_id=' + cattachment_id);
                            });
                        }
                    });
                });

                $('.delProject').click(function () {
                    $('#confirmDelProjectModal').modal('show');
                    public_project_id = $(this).attr('data-project-id');
                });
            }

            function onPostBodySon(res) {
                $("[data-toggle='tooltip']").tooltip();

                $('.delSonProject').click(function () {
                    $('#confirmDelSonProjectModal').modal('show');
                    var index = $(this).attr('data-sonproject-index');
                    public_sontable_index = $(this).attr('data-project-id');
                    var data = $('#sonproject-table-' + public_sontable_index).bootstrapTable('getData');
                    public_sonproject_id = data[index].id;
                });

                $('.editSonProject').click(function () {
                    $('#editSonProjectModal').modal('show');
                    var index = $(this).attr('data-sonproject-index');
                    public_sontable_index = $(this).attr('data-project-id');
                    var data = $('#sonproject-table-' + public_sontable_index).bootstrapTable('getData');
                    public_sonproject_id = data[index].id;
                    $('#edit-son-project-name').val(data[index].name);
                    addSonProfession('#edit-son-project-profession', data[index].profession, data[index].profession_id)
                    $('#edit-son-project-remark').val(data[index].remark);
                    $('#edit-cspattachment-table').bootstrapTable({
                        url: 'getCspattachment',
                        ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                        cache: false,
                        method: 'POST',
                        contentType: "application/x-www-form-urlencoded",
                        dataField: "data",
                        pageNumber: 1,
                        pagination: true,
                        search: false,
                        sidePagination: 'client',
                        pageSize: 6,//单页记录数
                        queryParams: function (params) {
                            return {
                                sonproject_id: data[index].id
                            }
                        },
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
                                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn showCspattachment" data-cspattachment-dir=' + row.dir + ' data-toggle="tooltip" data-original-title="查看"><i class="ti-eye" aria-hidden="true"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn downLoadCspattachment" data-cspattachment-dir=' + row.dir + ' data-toggle="tooltip" data-original-title="下载"><i class="ti-save" aria-hidden="true"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delCspattachment" data-cspattachment-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                            }
                        }],
                        onPostBody: function (res) {
                            $('.delCspattachment').click(function () {
                                var cspattachment_id = $(this).attr('data-cspattachment-id');
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: 'delCspattachment',
                                    type: 'POST',
                                    data: {
                                        cspattachment_id: cspattachment_id
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
                                            sonattachment();
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
                            $('.showCspattachment').click(function () {
                                var admininfo_pic_id = $(this).attr('data-admininfo-pic-id');
                                window.open('showAdmininfoPic?admininfo_pic_id=' + admininfo_pic_id);
                            });
                            $('.downLoadCspattachment').click(function () {
                                var admininfo_pic_id = $(this).attr('data-admininfo-pic-id');
                                window.open('downLoadAdmininfoPic?admininfo_pic_id=' + admininfo_pic_id);
                            });
                        }
                    });

                });
            }

            function addSonProfession(id, data, select) {
                $(id).empty();
                $(id).append('<option value="">请选择楼幢</option>');
                var count = data.length;
                var b = "";
                for (var i = 0; i < count; i++) {
                    b += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                }
                $(id).append(b);
                $(id).val(select);
            }

            $('#del-project-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'delCostProject',
                    type: 'POST',
                    data: {
                        project_id: public_project_id
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
                            $('#confirmDelProjectModal').modal('hide');
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

            $('#del-sonproject-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'delCostSonProject',
                    type: 'POST',
                    data: {
                        sonproject_id: public_sonproject_id
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
                            $('#confirmDelSonProjectModal').modal('hide');
                            sonrefresh(public_sontable_index);
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

            $('#add-contract-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'addContract',
                    type: 'POST',
                    data: {
                        contract_name: $('#add-contract-name').val(),
                        contract_type: $('#add-contract-type').val(),
                        address: $('#add-contract-address').val(),
                        sign_date: $('#add-contract-sign-date').val(),
                        start_date: $('#add-contract-start-date').val(),
                        end_date: $('#add-contract-end-date').val(),
                        construction_id: $('#add-contract-construction-id').val(),
                        agency_id: $('#add-contract-agency-id').val(),
                        contract_content: $('#add-contract-content').val(),
                        contract_remark: $('#add-contract-remark').val()
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
                            $('#addContractModal').modal('hide');
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

            $('#edit-contract-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'editContract',
                    type: 'POST',
                    data: {
                        contract_id: contract_id,
                        contract_name: $('#edit-contract-name').val(),
                        contract_type: $('#edit-contract-type').val(),
                        address: $('#edit-contract-address').val(),
                        sign_date: $('#edit-contract-sign-date').val(),
                        start_date: $('#edit-contract-start-date').val(),
                        end_date: $('#edit-contract-end-date').val(),
                        construction_id: $('#edit-contract-construction-id').val(),
                        agency_id: $('#edit-contract-agency-id').val(),
                        contract_content: $('#edit-contract-content').val(),
                        contract_remark: $('#edit-contract-remark').val()
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
                            $('#editContractModal').modal('hide');
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

            $('#addContractModal').on('hide.bs.modal', function () {
                clearModalInput();
            });

            $('#editSonProjectModal').on('hide.bs.modal', function () {
                $('#edit-cspattachment-table').bootstrapTable('destroy');
            });

            function clearModalInput() {
                $("#addContractForm")[0].reset();
            }

            $('#project-type-select').change(function () {
                refresh();
            });

            $('#project-search-button').click(function () {
                refresh();
            });
        })
    </script>
@endsection