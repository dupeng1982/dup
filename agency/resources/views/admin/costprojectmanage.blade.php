@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/jquery-combo-select/combo.select.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">造价项目分配</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">造价项目分配</li>
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
                                    <h4>造价项目分配列表</h4>
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
                        <form id="addProjectForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>项目名称*</label>
                                        <input type="text" class="form-control"
                                               id="add-project-name"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>项目类型*</label>
                                        <select class="custom-select form-control" id="add-project-service">
                                            <option value="">选择项目类型</option>
                                            @foreach($data['project_type'] as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>项目负责人</label>
                                        <select class="custom-select form-control" id="add-project-marcher">
                                            <option value="">选择项目负责人</option>
                                            @foreach($data['marcher'] as $v)
                                                <option value="{{ $v->admin_id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>专业类型*</label>
                                        <div class="c-inputs-stacked">
                                            <div class="row">
                                                @foreach($data['professions'] as $v)
                                                    <div class="col-md-4">
                                                        <label class="inline custom-control custom-checkbox block">
                                                            <input type="checkbox" class="custom-control-input"
                                                                   id="add-project-profession-{{ $v->id }}"
                                                                   name="add-project-professions-checkbox-group"
                                                                   value="{{ $v->id }}"> <span
                                                                    class="custom-control-indicator"></span>
                                                            <span class="custom-control-description ml-0">{{ $v->name }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>收费基数(万元)</label>
                                        <input type="text" class="form-control" id="add-project-cost"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>接收时间*</label>
                                        <input type="date" class="form-control" id="add-project-receive-date"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>项目合同</label>
                                        <select class="custom-select form-control"
                                                id="add-project-contract-select">
                                            <option value="">选择项目合同</option>
                                            @foreach($data['contract'] as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>合同编号</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="add-project-contract-number">
                                        <input type="hidden" id="add-project-contract-id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>建设单位</label>
                                        <select class="custom-select form-control"
                                                id="add-project-construction-select">
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
                                               id="add-project-construction-contact">
                                        <input type="hidden" id="add-project-construction-id">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>联系电话</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="add-project-construction-phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>委托单位</label>
                                        <select class="custom-select form-control"
                                                id="add-project-agency-select">
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
                                               id="add-project-agency-contact">
                                        <input type="hidden" id="add-project-agency-id">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>联系电话</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="add-project-agency-phone"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>施工单位</label>
                                        <select class="custom-select form-control"
                                                id="add-project-implement-select">
                                            <option value="">选择施工单位</option>
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
                                               id="add-project-implement-contact">
                                        <input type="hidden" id="add-project-implement-id">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>联系电话</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="add-project-implement-phone"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>备注</label>
                                        <textarea name="remark" id="add-project-remark"
                                                  rows="6" class="form-control" style="overflow-x:hidden"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="add-project-submit"
                            class="btn btn-success">提交
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="addCpattachmentModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">附件管理</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row" id="aetherupload-wrapper">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>附件名称*</label>
                                    <input type="text" class="form-control" id="max-file-name">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>添加附件*</label>
                                    <input type="file" class="form-control" id="file">
                                </div>
                                <div class="progress" id="upload-progress"
                                     style="height: 6px;margin-bottom: 2px;margin-top: 10px;width: 200px;">
                                    <div id="progressbar" style="background:blue;height:6px;width:0;"></div>
                                </div>
                                <span style="font-size:12px;color:#aaa;" id="output"></span>
                                <input type="hidden" name="file1" id="savedpath">
                                <input type="hidden" id="upload-operator-id"
                                       value="{{ Auth::guard('admin')->user()->id }}">
                                <input type="hidden" id="upload-project-id" value="">
                                <input type="hidden" id="check-status" value="">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label></label>
                                    <p>
                                        <button type="button" id="add-cpattachment-button"
                                                class="btn waves-effect waves-light btn-rounded btn-secondary"
                                                style="top :10px;">添加
                                        </button>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover toggle-circle"
                                       data-page-size="7" id="add-cpattachment-table">
                                </table>
                            </div>
                        </div>
                    </div>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>项目名称*</label>
                                    <input type="text" class="form-control"
                                           id="edit-project-name"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>项目类型*</label>
                                    <select class="custom-select form-control" id="edit-project-service">
                                        <option value="">选择项目类型</option>
                                        @foreach($data['project_type'] as $v)
                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>项目负责人</label>
                                    <select class="custom-select form-control" id="edit-project-marcher">
                                        <option value="">选择项目负责人</option>
                                        @foreach($data['marcher'] as $v)
                                            <option value="{{ $v->admin_id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>专业类型*</label>
                                    <div class="c-inputs-stacked">
                                        <div class="row">
                                            @foreach($data['professions'] as $v)
                                                <div class="col-md-4">
                                                    <label class="inline custom-control custom-checkbox block">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="edit-project-profession-{{ $v->id }}"
                                                               name="edit-project-professions-checkbox-group"
                                                               value="{{ $v->id }}"> <span
                                                                class="custom-control-indicator"></span>
                                                        <span class="custom-control-description ml-0">{{ $v->name }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>收费基数(万元)</label>
                                    <input type="text" class="form-control" id="edit-project-cost"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>接收时间*</label>
                                    <input type="date" class="form-control" id="edit-project-receive-date"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>项目合同</label>
                                    <select class="custom-select form-control"
                                            id="edit-project-contract-select">
                                        <option value="">选择项目合同</option>
                                        @foreach($data['contract'] as $v)
                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>合同编号</label>
                                    <input type="text" class="form-control" disabled="disabled"
                                           id="edit-project-contract-number">
                                    <input type="hidden" id="edit-project-contract-id">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>建设单位</label>
                                    <select class="custom-select form-control"
                                            id="edit-project-construction-select">
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
                                           id="edit-project-construction-contact">
                                    <input type="hidden" id="edit-project-construction-id">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>联系电话</label>
                                    <input type="text" class="form-control" disabled="disabled"
                                           id="edit-project-construction-phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>委托单位</label>
                                    <select class="custom-select form-control"
                                            id="edit-project-agency-select">
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
                                           id="edit-project-agency-contact">
                                    <input type="hidden" id="edit-project-agency-id">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>联系电话</label>
                                    <input type="text" class="form-control" disabled="disabled"
                                           id="edit-project-agency-phone"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>施工单位</label>
                                    <select class="custom-select form-control"
                                            id="edit-project-implement-select">
                                        <option value="">选择施工单位</option>
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
                                           id="edit-project-implement-contact">
                                    <input type="hidden" id="edit-project-implement-id">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>联系电话</label>
                                    <input type="text" class="form-control" disabled="disabled"
                                           id="edit-project-implement-phone"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>备注</label>
                                    <textarea name="remark" id="edit-project-remark"
                                              rows="6" class="form-control" style="overflow-x:hidden"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="edit-project-submit"
                            class="btn btn-success">提交
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="addSonProjectModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">添加专项</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="add-cost-son-project-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>专项名称*</label>
                                        <input type="text" class="form-control" id="add-son-project-name"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>专业类型*</label>
                                        <select class="custom-select form-control" id="add-son-project-profession">
                                            <option value="">选择专业类型</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>收费基数(万元)</label>
                                        <input type="text" class="form-control" id="add-son-project-cost"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>备注</label>
                                        <textarea name="remark" id="add-son-project-remark"
                                                  rows="6" class="form-control" style="overflow-x:hidden"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="add-son-project-submit"
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
                    <h4 class="modal-title">编辑专项</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>专项名称*</label>
                                        <input type="text" class="form-control"
                                               id="edit-son-project-name"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>专业类型*</label>
                                        <select class="custom-select form-control" id="edit-son-project-profession">
                                            <option value="">选择专业类型</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>收费基数(万元)</label>
                                        <input type="text" class="form-control" id="edit-son-project-cost"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>备注</label>
                                        <textarea name="remark" id="edit-son-project-remark"
                                                  rows="6" class="form-control" style="overflow-x:hidden"></textarea>
                                    </div>
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
    <div class="modal fade show" id="allotSonProjectModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">分配专项</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>专项名称</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="allot-son-project-name"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>专业类型</label>
                                        <select class="custom-select form-control" disabled="disabled"
                                                id="allot-son-project-profession">
                                            <option value="">选择专业类型</option>
                                            @foreach($data['professions'] as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>收费基数(万元)</label>
                                        <input type="text" class="form-control" id="allot-son-project-cost"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>专项实施人</label>
                                        <select class="custom-select form-control" id="allot-son-project-marcher">
                                            <option value="">选择专项实施人</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>提成比例</label>
                                        <input type="text" class="form-control" id="allot-son-project-basic-rate">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>考核提成比例</label>
                                        <input type="text" class="form-control" id="allot-son-project-check-rate">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>专项开始时间</label>
                                        <input type="date" class="form-control" id="allot-son-project-start-date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>专项结束时间</label>
                                        <input type="date" class="form-control" id="allot-son-project-end-date">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>审核说明</label>
                                        <textarea name="remark" id="allot-son-project-check-mark"
                                                  rows="6" class="form-control" style="overflow-x:hidden"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="allot-son-project-submit"
                            class="btn btn-success">分配
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
    <script src="{{ asset('js/spark-md5.min.js') }}"></script>
    <script src="{{ asset('js/aetherupload.js') }}"></script>
    <script>
        $(function () {
            var public_project_id;
            var public_sonproject_id;
            var public_sontable_index;

            $('#add-project-contract-select').comboSelect();
            $('#add-project-contract-select').change(function () {
                var construction_id = $(this).val();
                var construction_select = {!! $data['contract'] !!};
                var construction_selected = construction_select.filter(function (e) {
                    if (e.id == construction_id) {
                    } else {
                        return null;
                    }
                    return e;
                });

                var contract_number = construction_selected[0] ? construction_selected[0].number_name : null;
                var contract_id = construction_selected[0] ? construction_selected[0].id : null;

                var construction_id = construction_selected[0] ? construction_selected[0].construction_id : null;
                var agency_id = construction_selected[0] ? construction_selected[0].agency_id : null;

                $('#add-project-contract-number').val(contract_number);
                $('#add-project-contract-id').val(contract_id);

                if (construction_id) {
                    var construction_phone = construction_selected[0].construction.phone;
                    var construction_name = construction_selected[0].construction.name;
                    var construction_contact = construction_selected[0].construction.contact;
                    $('#add-project-construction-contact').val(construction_contact);
                    $('#add-project-construction-phone').val(construction_phone);
                    $('#add-project-construction-id').val(construction_id);
                    $('#add-project-construction-select').nextAll('input[type="text"]').val(construction_name);
                } else {
                    $('#add-project-construction-contact').val('');
                    $('#add-project-construction-phone').val('');
                    $('#add-project-construction-id').val('');
                    $('#add-project-construction-select').nextAll('input[type="text"]').val('选择建设单位');
                }
                if (agency_id) {
                    var agency_phone = construction_selected[0].agency.phone;
                    var agency_name = construction_selected[0].agency.name;
                    var agency_contact = construction_selected[0].agency.contact;
                    $('#add-project-agency-contact').val(agency_contact);
                    $('#add-project-agency-phone').val(agency_phone);
                    $('#add-project-agency-id').val(agency_id);
                    $('#add-project-agency-select').nextAll('input[type="text"]').val(agency_name);
                } else {
                    $('#add-project-agency-contact').val('');
                    $('#add-project-agency-phone').val('');
                    $('#add-project-agency-id').val('');
                    $('#add-project-agency-select').nextAll('input[type="text"]').val('选择委托单位');
                }
            });
            $('#add-project-construction-select').comboSelect();
            $('#add-project-construction-select').change(function () {
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

                $('#add-project-construction-contact').val(construction_contact);
                $('#add-project-construction-phone').val(construction_phone);
                $('#add-project-construction-id').val(construction_id);
            });
            $('#add-project-agency-select').comboSelect();
            $('#add-project-agency-select').change(function () {
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

                $('#add-project-agency-contact').val(agency_contact);
                $('#add-project-agency-phone').val(agency_phone);
                $('#add-project-agency-id').val(agency_id);
            });
            $('#add-project-implement-select').comboSelect();
            $('#add-project-implement-select').change(function () {
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

                $('#add-project-implement-contact').val(agency_contact);
                $('#add-project-implement-phone').val(agency_phone);
                $('#add-project-implement-id').val(agency_id);
            });

            $('#edit-project-contract-select').comboSelect();
            $('#edit-project-contract-select').change(function () {
                var construction_id = $(this).val();
                var construction_select = {!! $data['contract'] !!};
                var construction_selected = construction_select.filter(function (e) {
                    if (e.id == construction_id) {
                    } else {
                        return null;
                    }
                    return e;
                });

                var contract_number = construction_selected[0] ? construction_selected[0].number_name : null;
                var contract_id = construction_selected[0] ? construction_selected[0].id : null;

                var construction_id = construction_selected[0] ? construction_selected[0].construction_id : null;
                var agency_id = construction_selected[0] ? construction_selected[0].agency_id : null;

                $('#edit-project-contract-number').val(contract_number);
                $('#edit-project-contract-id').val(contract_id);

                if (construction_id) {
                    var construction_phone = construction_selected[0].construction.phone;
                    var construction_name = construction_selected[0].construction.name;
                    var construction_contact = construction_selected[0].construction.contact;
                    $('#edit-project-construction-contact').val(construction_contact);
                    $('#edit-project-construction-phone').val(construction_phone);
                    $('#edit-project-construction-id').val(construction_id);
                    $('#edit-project-construction-select').nextAll('input[type="text"]').val(construction_name);
                } else {
                    $('#edit-project-construction-contact').val('');
                    $('#edit-project-construction-phone').val('');
                    $('#edit-project-construction-id').val('');
                    $('#edit-project-construction-select').nextAll('input[type="text"]').val('选择建设单位');
                }
                if (agency_id) {
                    var agency_phone = construction_selected[0].agency.phone;
                    var agency_name = construction_selected[0].agency.name;
                    var agency_contact = construction_selected[0].agency.contact;
                    $('#edit-project-agency-contact').val(agency_contact);
                    $('#edit-project-agency-phone').val(agency_phone);
                    $('#edit-project-agency-id').val(agency_id);
                    $('#edit-project-agency-select').nextAll('input[type="text"]').val(agency_name);
                } else {
                    $('#edit-project-agency-contact').val('');
                    $('#edit-project-agency-phone').val('');
                    $('#edit-project-agency-id').val('');
                    $('#edit-project-agency-select').nextAll('input[type="text"]').val('选择委托单位');
                }
            });
            $('#edit-project-construction-select').comboSelect();
            $('#edit-project-construction-select').change(function () {
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

                $('#edit-project-construction-contact').val(construction_contact);
                $('#edit-project-construction-phone').val(construction_phone);
                $('#edit-project-construction-id').val(construction_id);
            });
            $('#edit-project-agency-select').comboSelect();
            $('#edit-project-agency-select').change(function () {
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

                $('#edit-project-agency-contact').val(agency_contact);
                $('#edit-project-agency-phone').val(agency_phone);
                $('#edit-project-agency-id').val(agency_id);
            });
            $('#edit-project-implement-select').comboSelect();
            $('#edit-project-implement-select').change(function () {
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

                $('#edit-project-implement-contact').val(agency_contact);
                $('#edit-project-implement-phone').val(agency_phone);
                $('#edit-project-implement-id').val(agency_id);
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
                    field: 'marcher_name',
                    title: '负责人'
                }, {
                    field: 'recorder_name',
                    title: '录入人'
                }, {
                    field: 'status_txt',
                    title: '项目进度'
                }, {
                    field: 'id',
                    title: '操作<button type="button" id="addProject" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="添加专项"><i class="ti-user" aria-hidden="true"></i></button>',
                    formatter: function (value, row, index) {
                        return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn addCpattachment" data-project-index=' + index + ' data-toggle="tooltip" data-original-title="附件管理"><i class="ti-file" aria-hidden="true"></i></button>' +
                            '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editProject" data-project-index=' + index + ' data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt" aria-hidden="true"></i></button>' +
                            '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delProject" data-project-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                    }
                }],
                onPostBody: onPostBody,
                detailView: true,
                onExpandRow: function (index, row, $detail) {
                    var son_table = $detail.html('<table id="sonproject-table-' + row.id + '" class="table table-bordered table-hover toggle-circle" data-page-size="6"></table>').find('table');
                    var marcher_id = row.marcher_id;
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
                            title: '专项编号'
                        }, {
                            field: 'name',
                            title: '专项名称'
                        }, {
                            field: 'profession_name',
                            title: '专业类型'
                        }, {
                            field: 'status_txt',
                            title: '专项进度'
                        }, {
                            field: 'marcher_name',
                            title: '实施人'
                        }, {
                            field: 'id',
                            title: '操作<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn addSonProject" data-project-index=' + index + ' data-project-id=' + row.id + ' data-toggle="tooltip" data-original-title="添加子项目"><i class="ti-user" aria-hidden="true"></i></button>',
                            formatter: function (value, row, index) {
                                if (marcher_id && row.status == 0) {
                                    return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn allotSonProject" data-project-id=' + row.project_id + ' data-sonproject-index=' + index + ' data-toggle="tooltip" data-original-title="分配"><i class="ti-stamp" aria-hidden="true"></i></button>' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editSonProject" data-project-id=' + row.project_id + ' data-sonproject-index=' + index + ' data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt" aria-hidden="true"></i></button>' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delSonProject" data-project-id=' + row.project_id + ' data-sonproject-index=' + index + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                                } else {
                                    return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editSonProject" data-project-id=' + row.project_id + ' data-sonproject-index=' + index + ' data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt" aria-hidden="true"></i></button>' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delSonProject" data-project-id=' + row.project_id + ' data-sonproject-index=' + index + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                                }

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

            function attachment() {
                $('#add-cpattachment-table').bootstrapTable('refresh', {url: 'getCpattachment'});
            }

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();

                $('#addProject').click(function () {
                    $('#addProjectModal').modal('show');
                });

                $('.editProject').click(function () {
                    $('#editProjectModal').modal('show');

                    var data = $('#project_table').bootstrapTable('getData');
                    var index = $(this).attr('data-project-index');
                    public_project_id = data[index].id;
                    $('#edit-project-name').val(data[index].name);
                    $('#edit-project-service').val(data[index].service_id);
                    $('#edit-project-marcher').val(data[index].marcher_id);
                    data[index].profession.map(function (value, index, array) {
                        $("#edit-project-profession-" + value.id).prop("checked",true);
                    });
                    $('#edit-project-cost').val(data[index].cost);
                    $('#edit-project-receive-date').val(data[index].receive_date);

                    $('#edit-project-construction-id').val(data[index].construction_id);
                    $('#edit-project-construction-select').nextAll('input[type="text"]').val(data[index].construction_name);
                    $('#edit-project-construction-contact').val(data[index].construction_contact);
                    $('#edit-project-construction-phone').val(data[index].construction_phone);

                    $('#edit-project-agency-id').val(data[index].agency_id);
                    $('#edit-project-agency-select').nextAll('input[type="text"]').val(data[index].agency_name);
                    $('#edit-project-agency-contact').val(data[index].agency_contact);
                    $('#edit-project-agency-phone').val(data[index].agency_phone);

                    $('#edit-project-implement-id').val(data[index].implement_id);
                    $('#edit-project-implement-select').nextAll('input[type="text"]').val(data[index].implement_name);
                    $('#edit-project-implement-contact').val(data[index].implement_contact);
                    $('#edit-project-implement-phone').val(data[index].implement_phone);

                    $('#edit-project-contract-id').val(data[index].contract_id);
                    if (data[index].contract) {
                        $('#edit-project-contract-select').nextAll('input[type="text"]').val(data[index].contract.name);
                        $('#edit-project-contract-number').val(data[index].contract.number_name);
                    } else {
                        $('#edit-project-contract-select').nextAll('input[type="text"]').val('选择项目合同');
                        $('#edit-project-contract-number').val('');
                    }
                    $('#edit-project-remark').val(data[index].remark);
                });

                $('.delProject').click(function () {
                    $('#confirmDelProjectModal').modal('show');
                    public_project_id = $(this).attr('data-project-id');
                });

                $('.addCpattachment').click(function () {
                    $('#addCpattachmentModal').modal('show');
                    $('#upload-progress').hide();
                    $('#output').val('');
                    $('#output').hide();

                    var data = $('#project_table').bootstrapTable('getData');
                    var index = $(this).attr('data-project-index');
                    $('#upload-project-id').val(data[index].id);
                    $('#check-status').val(0);
                    $('#add-cpattachment-table').bootstrapTable({
                        url: 'getCpattachment',
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
                                project_id: data[index].id
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
                            field: 'operator_name',
                            title: '上传人'
                        }, {
                            field: 'check_name',
                            title: '审核类型'
                        }, {
                            field: 'id',
                            title: '操作',
                            formatter: function (value, row, index) {
                                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn showCpattachment" data-cpattachment-dir=' + row.dir + ' data-toggle="tooltip" data-original-title="查看"><i class="ti-eye" aria-hidden="true"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn downLoadCpattachment" data-cpattachment-dir=' + row.dir + ' data-cpattachment-name=' + row.name + ' data-toggle="tooltip" data-original-title="下载"><i class="ti-save" aria-hidden="true"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delCpattachment" data-cpattachment-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                            }
                        }],
                        onPostBody: function (res) {
                            $('.delCpattachment').click(function () {
                                var cpattachment_id = $(this).attr('data-cpattachment-id');
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: 'delCpattachment',
                                    type: 'POST',
                                    data: {
                                        cpattachment_id: cpattachment_id
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
                                            attachment();
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
                            $('.showCpattachment').click(function () {
                                var dir = $(this).attr('data-cpattachment-dir');
                                window.open('aetherupload/display/' + dir);
                            });
                            $('.downLoadCpattachment').click(function () {
                                var dir = $(this).attr('data-cpattachment-dir');
                                var name = $(this).attr('data-cpattachment-name');
                                window.open('aetherupload/download/' + dir + '/' + name);
                            });
                        }
                    });
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
                    public_project_id = $(this).attr('data-project-id');
                    public_sontable_index = $(this).attr('data-project-id');
                    var data = $('#sonproject-table-' + public_sontable_index).bootstrapTable('getData');
                    public_sonproject_id = data[index].id;
                    $('#edit-son-project-name').val(data[index].name);
                    addSonProfession('#edit-son-project-profession', data[index].profession, data[index].profession_id);
                    $('#edit-son-project-remark').val(data[index].remark);
                    $('#edit-son-project-cost').val(data[index].cost);
                });

                $('.addSonProject').click(function () {
                    $('#addSonProjectModal').modal('show');
                    public_project_id = $(this).attr('data-project-id');
                    public_sontable_index = $(this).attr('data-project-id');
                    var index = $(this).attr('data-project-index');
                    var data = $('#project_table').bootstrapTable('getData');
                    addSonProfession('#add-son-project-profession', data[index].profession);
                });

                $('.allotSonProject').click(function () {
                    $('#allotSonProjectModal').modal('show');
                    var index = $(this).attr('data-sonproject-index');
                    public_project_id = $(this).attr('data-project-id');
                    public_sontable_index = $(this).attr('data-project-id');
                    var data = $('#sonproject-table-' + public_sontable_index).bootstrapTable('getData');
                    public_sonproject_id = data[index].id;
                    $('#allot-son-project-name').val(data[index].name);
                    $('#allot-son-project-profession').val(data[index].profession_id);
                    $('#allot-son-project-cost').val(data[index].cost);
                    addSonMarcher('#allot-son-project-marcher', data[index].marchers, data[index].marcher_id);
                    $('#allot-son-project-basic-rate').val(data[index].rates.basic_rate);
                    $('#allot-son-project-check-rate').val(data[index].rates.check_rate);
                    $('#allot-son-project-start-date').val(data[index].start_date);
                    $('#allot-son-project-end-date').val(data[index].end_date);
                    $('#allot-son-project-check-mark').val(data[index].check_mark);
                });
            }

            function addSonProfession(id, data, select) {
                $(id).empty();
                $(id).append('<option value="">选择专业类型</option>');
                var count = data.length;
                var b = "";
                for (var i = 0; i < count; i++) {
                    b += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                }
                $(id).append(b);
                $(id).val(select);
            }

            function addSonMarcher(id, data, select) {
                $(id).empty();
                $(id).append('<option value="">选择专项实施人</option>');
                var count = data.length;
                var b = "";
                for (var i = 0; i < count; i++) {
                    b += "<option value='" + data[i].admin_id + "'>" + data[i].name + "</option>";
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

            $('#add-project-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'addCostProject',
                    type: 'POST',
                    data: {
                        project_name: $('#add-project-name').val(),
                        service_id: $('#add-project-service').val(),
                        marcher_id: $('#add-project-marcher').val(),
                        profession: $("input[name='add-project-professions-checkbox-group']:checked")
                            .map(function (index, elem) {
                                return $(elem).val();
                            }).get(),
                        cost: $('#add-project-cost').val(),
                        receive_date: $('#add-project-receive-date').val(),
                        construction_id: $('#add-project-construction-id').val(),
                        implement_id: $('#add-project-implement-id').val(),
                        agency_id: $('#add-project-agency-id').val(),
                        contract_id: $('#add-project-contract-id').val(),
                        remark: $('#add-project-remark').val()
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
                            $('#addProjectModal').modal('hide');
                            clearModalInput()
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

            $('#add-son-project-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'addCostSonProject',
                    type: 'POST',
                    data: {
                        project_id: public_project_id,
                        sonproject_name: $('#add-son-project-name').val(),
                        profession_id: $('#add-son-project-profession').val(),
                        remark: $('#add-son-project-remark').val(),
                        cost: $('#add-son-project-cost').val()
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
                            $('#addSonProjectModal').modal('hide');
                            clearModalInput()
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

            $('#edit-project-submit').click(function () {
                console.log($("input[name='edit-project-professions-checkbox-group']:checked")
                    .map(function (index, elem) {
                        return $(elem).val();
                    }).get());
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'editCostProject',
                    type: 'POST',
                    data: {
                        project_id: public_project_id,
                        project_name: $('#edit-project-name').val(),
                        service_id: $('#edit-project-service').val(),
                        marcher_id: $('#edit-project-marcher').val(),
                        profession: $("input[name='edit-project-professions-checkbox-group']:checked")
                            .map(function (index, elem) {
                                return $(elem).val();
                            }).get(),
                        cost: $('#edit-project-cost').val(),
                        receive_date: $('#edit-project-receive-date').val(),
                        construction_id: $('#edit-project-construction-id').val(),
                        implement_id: $('#edit-project-implement-id').val(),
                        agency_id: $('#edit-project-agency-id').val(),
                        contract_id: $('#edit-project-contract-id').val(),
                        remark: $('#edit-project-remark').val()
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
                            $('#editProjectModal').modal('hide');
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

            $('#edit-son-project-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'editCostSonProject',
                    type: 'POST',
                    data: {
                        sonproject_id: public_sonproject_id,
                        sonproject_name: $('#edit-son-project-name').val(),
                        profession_id: $('#edit-son-project-profession').val(),
                        remark: $('#edit-son-project-remark').val(),
                        cost: $('#edit-son-project-cost').val()
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
                            $('#editSonProjectModal').modal('hide');
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

            $('#allot-son-project-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'allotCostSonProject',
                    type: 'POST',
                    data: {
                        sonproject_id: public_sonproject_id,
                        cost: $('#allot-son-project-cost').val(),
                        son_marcher_id: $('#allot-son-project-marcher').val(),
                        basic_rate: $('#allot-son-project-basic-rate').val(),
                        check_rate: $('#allot-son-project-check-rate').val(),
                        start_date: $('#allot-son-project-start-date').val(),
                        end_date: $('#allot-son-project-end-date').val(),
                        check_mark: $('#allot-son-project-check-mark').val()
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
                            $('#allotSonProjectModal').modal('hide');
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

            $('#addCpattachmentModal').on('hide.bs.modal', function () {
                $('#add-cpattachment-table').bootstrapTable('destroy');
            });

            $('#editProjectModal').on('hide.bs.modal', function () {
                $("input[name='edit-project-professions-checkbox-group']")
                    .map(function (index, elem) {
                        $(elem).prop("checked",false);
                    });
            });

            $('#editSonProjectModal').on('hide.bs.modal', function () {
                $('#edit-cspattachment-table').bootstrapTable('destroy');
            });

            function clearModalInput() {
                $("#addProjectForm")[0].reset();
                $('#add-cost-son-project-form')[0].reset();
            }

            $('#project-type-select').change(function () {
                refresh();
            });

            $('#project-search-button').click(function () {
                refresh();
            });

            //文件上传
            $('#add-cpattachment-button').click(function () {
                $('#upload-progress').show();
                $('#output').show();
                aetherupload(this, 'file').success(someCallback).upload();
            });
            someCallback = function () {
                attachment();
                $('#max-file-name').val('');
                $('#file').val('');
            }
        })
    </script>
@endsection