@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/jquery-combo-select/combo.select.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">造价项目审核</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">造价项目审核</li>
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
                                    <h4>造价项目审核列表</h4>
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
                    <h4 class="modal-title">项目详情</h4>
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
                                              rows="6" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="checkProjectModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">项目审核</h4>
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
                                    <input type="text" class="form-control" disabled="disabled"
                                           id="check-project-name"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>项目类型*</label>
                                    <select class="custom-select form-control" disabled="disabled" id="check-project-service">
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
                                    <select class="custom-select form-control" disabled="disabled" id="check-project-marcher">
                                        <option value="">选择项目负责人</option>
                                        @foreach($data['marcher'] as $v)
                                            <option value="{{ $v->admin_id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>收费基数(万元)</label>
                                    <input type="text" class="form-control" id="check-project-cost"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>费率‰</label>
                                    <input type="text" class="form-control" id="check-project-basic-rate"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>最小费用(元)</label>
                                    <input type="text" class="form-control" id="check-project-min-profit"></div>
                            </div>
                        </div>
                        <div class="row" id="check-project-check-info">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>核定基数(万元)</label>
                                    <input type="text" class="form-control" id="check-project-checkcost"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>核定率%</label>
                                    <input type="text" class="form-control" id="check-project-check-rate"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>核定费率%</label>
                                    <input type="text" class="form-control" id="check-project-check-cost-rate"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>服务收费(万元)</label>
                                    <input type="text" class="form-control" disabled="disabled" id="check-project-service-fee"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="check-project-check-money-show">
                                    <label>核增核减额(万元)</label>
                                    <input type="text" class="form-control" disabled="disabled" id="check-project-check-money"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover toggle-circle"
                                       data-page-size="7" id="sonproject-cost-table">
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>审核说明</label>
                                    <textarea name="remark" id="check-project-checkmark"
                                              rows="6" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="check-project-sum-cost"
                            class="btn btn-success">费用计算
                    </button>
                    <button type="button" id="check-project-submit"
                            class="btn btn-success">审核
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
                    <h4 class="modal-title">专项详情</h4>
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
                            <div class="row" id="cost-sonproject-check-cost-show">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>核定基数(万元)</label>
                                        <input type="text" class="form-control" id="edit-son-project-checkcost"></div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>专项实施人</label>
                                        <select class="custom-select form-control" id="edit-son-project-marcher">
                                            <option value="">选择专项实施人</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>提成比例</label>
                                        <input type="text" class="form-control" id="edit-son-project-basic-rate">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>考核提成比例</label>
                                        <input type="text" class="form-control" id="edit-son-project-check-rate">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>专项开始时间</label>
                                        <input type="date" class="form-control" id="edit-son-project-start-date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>专项结束时间</label>
                                        <input type="date" class="form-control" id="edit-son-project-end-date">
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
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
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
                    <h4 class="modal-title">专项审核</h4>
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
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="allot-son-project-cost"></div>
                                </div>
                            </div>
                            <div class="row" id="cost-sonproject-check-cost">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>核定基数(万元)</label>
                                        <input type="text" class="form-control" disabled="disabled"
                                               id="allot-son-project-checkcost"></div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>审核说明</label>
                                        <textarea name="remark" id="allot-son-project-check-mark"
                                                  rows="3" class="form-control"></textarea>
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
                            class="btn btn-success">退回
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
            var operator_id = $('#upload-operator-id').val();
            var service_id;

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
                url: 'getCostProjectCCheckList',
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
                    title: '操作',
                    formatter: function (value, row, index) {
                        if (row.show_check) {console.log(row.show_check);
                            return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn checkProject" data-project-index=' + index + ' data-toggle="tooltip" data-original-title="审核"><i class="ti-stamp" aria-hidden="true"></i></button>' +
                                '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn addCpattachment" data-project-index=' + index + ' data-toggle="tooltip" data-original-title="附件管理"><i class="ti-file" aria-hidden="true"></i></button>' +
                                '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editProject" data-project-index=' + index + ' data-toggle="tooltip" data-original-title="查看"><i class="ti-eye" aria-hidden="true"></i></button>';
                        } else {
                            return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn addCpattachment" data-project-index=' + index + ' data-toggle="tooltip" data-original-title="附件管理"><i class="ti-file" aria-hidden="true"></i></button>' +
                                '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editProject" data-project-index=' + index + ' data-toggle="tooltip" data-original-title="查看"><i class="ti-eye" aria-hidden="true"></i></button>';
                        }
                    }
                }],
                onPostBody: onPostBody,
                detailView: true,
                onExpandRow: function (index, row, $detail) {
                    var son_table = $detail.html('<table id="sonproject-table-' + row.id + '" class="table table-bordered table-hover toggle-circle" data-page-size="6"></table>').find('table');
                    var marcher_id = row.marcher_id;
                    var service_id = row.service_id;
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
                            title: '操作',
                            formatter: function (value, row, index) {
                                if (row.status == 3 && marcher_id) {
                                    return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn allotSonProject" data-project-id=' + row.project_id + ' data-sonproject-index=' + index + ' data-service-id=' + service_id + ' data-toggle="tooltip" data-original-title="审核"><i class="ti-stamp" aria-hidden="true"></i></button>' +
                                        '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editSonProject" data-project-id=' + row.project_id + ' data-sonproject-index=' + index + ' data-service-id=' + service_id + ' data-toggle="tooltip" data-original-title="查看"><i class="ti-eye" aria-hidden="true"></i></button>';
                                } else {
                                    return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editSonProject" data-project-id=' + row.project_id + ' data-sonproject-index=' + index + ' data-service-id=' + service_id + ' data-toggle="tooltip" data-original-title="查看"><i class="ti-eye" aria-hidden="true"></i></button>';
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
                $('#project_table').bootstrapTable('refresh', {url: 'getCostProjectCCheckList'});
            }

            function sonrefresh(project_id) {
                $('#sonproject-table-' + project_id).bootstrapTable('refresh', {url: 'getCostSonProjectList'});
            }

            function attachment() {
                $('#add-cpattachment-table').bootstrapTable('refresh', {url: 'getCpattachment'});
            }

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();

                $('.editProject').click(function () {
                    $('#editProjectModal').modal('show');

                    var data = $('#project_table').bootstrapTable('getData');
                    var index = $(this).attr('data-project-index');
                    public_project_id = data[index].id;
                    $('#edit-project-name').val(data[index].name);
                    $('#edit-project-service').val(data[index].service_id);
                    $('#edit-project-marcher').val(data[index].marcher_id);
                    data[index].profession.map(function (value, index, array) {
                        $("#edit-project-profession-" + value.id).prop("checked", true);
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

                $('.addCpattachment').click(function () {
                    $('#addCpattachmentModal').modal('show');
                    $('#upload-progress').hide();
                    $('#output').val('');
                    $('#output').hide();

                    var data = $('#project_table').bootstrapTable('getData');
                    var index = $(this).attr('data-project-index');
                    $('#upload-project-id').val(data[index].id);
                    $('#check-status').val(3);
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

                $('.checkProject').click(function () {
                    $('#checkProjectModal').modal('show');

                    var data = $('#project_table').bootstrapTable('getData');
                    var index = $(this).attr('data-project-index');
                    public_project_id = data[index].id;
                    $('#check-project-name').val(data[index].name);
                    var service_id = data[index].service_id;
                    $('#check-project-service').val(data[index].service_id);
                    $('#check-project-marcher').val(data[index].marcher_id);
                    $('#check-project-cost').val(data[index].cost);
                    $('#check-project-checkmark').val(data[index].check_mark);
                    $('#check-project-basic-rate').val(data[index].basic_rate);
                    $('#check-project-min-profit').val(data[index].min_profit);
                    $('#check-project-checkcost').val(data[index].check_cost);
                    $('#check-project-check-rate').val(data[index].check_rate);
                    $('#check-project-check-cost-rate').val(data[index].check_cost_rate);
                    $('#check-project-check-money').val(data[index].check_money);
                    $('#check-project-service-fee').val(data[index].service_money);

                    if (service_id == 19) {
                        $('#check-project-check-info').show();
                        $('#check-project-check-money-show').show();
                        $('#sonproject-cost-table').bootstrapTable({
                            data: data[index].sonproject,
                            pageNumber: 1,
                            pagination: false,
                            search: false,
                            sidePagination: 'client',
                            pageSize: 10,//单页记录数
                            columns: [{
                                field: 'SerialNumber',
                                title: '序号',
                                formatter: function (value, row, index) {
                                    return index + 1;
                                }
                            }, {
                                field: 'profession_name',
                                title: '专项名称'
                            }, {
                                field: 'cost',
                                title: '收费基数(万元)'
                            }, {
                                field: 'check_cost',
                                title: '核定基数(万元)'
                            }]
                        });
                    } else {
                        $('#check-project-check-info').hide();
                        $('#check-project-check-money-show').hide();
                        $('#sonproject-cost-table').bootstrapTable({
                            data: data[index].sonproject,
                            pageNumber: 1,
                            pagination: false,
                            search: false,
                            sidePagination: 'client',
                            pageSize: 10,//单页记录数
                            columns: [{
                                field: 'SerialNumber',
                                title: '序号',
                                formatter: function (value, row, index) {
                                    return index + 1;
                                }
                            }, {
                                field: 'profession_name',
                                title: '专项名称'
                            }, {
                                field: 'cost',
                                title: '收费基数(万元)'
                            }]
                        });
                    }
                });
            }

            function onPostBodySon(res) {
                $("[data-toggle='tooltip']").tooltip();

                $('.editSonProject').click(function () {
                    $('#editSonProjectModal').modal('show');
                    service_id = $(this).attr('data-service-id');
                    if (service_id == 19) {
                        $('#cost-sonproject-check-cost-show').show();
                    } else {
                        $('#cost-sonproject-check-cost-show').hide();
                    }

                    var index = $(this).attr('data-sonproject-index');
                    public_project_id = $(this).attr('data-project-id');
                    public_sontable_index = $(this).attr('data-project-id');
                    var data = $('#sonproject-table-' + public_sontable_index).bootstrapTable('getData');
                    public_sonproject_id = data[index].id;
                    $('#edit-son-project-name').val(data[index].name);
                    addSonProfession('#edit-son-project-profession', data[index].profession, data[index].profession_id);
                    $('#edit-son-project-remark').val(data[index].remark);
                    $('#edit-son-project-cost').val(data[index].cost);
                    addSonMarcher('#edit-son-project-marcher', data[index].marchers, data[index].marcher_id);
                    $('#edit-son-project-basic-rate').val(data[index].rates.basic_rate);
                    $('#edit-son-project-check-rate').val(data[index].rates.check_rate);
                    $('#edit-son-project-start-date').val(data[index].start_date);
                    $('#edit-son-project-end-date').val(data[index].end_date);
                    $('#edit-son-project-checkcost').val(data[index].check_cost);
                });

                $('.allotSonProject').click(function () {
                    $('#allotSonProjectModal').modal('show');
                    service_id = $(this).attr('data-service-id');
                    if (service_id == 19) {
                        $('#cost-sonproject-check-cost').show();
                    } else {
                        $('#cost-sonproject-check-cost').hide();
                    }
                    var index = $(this).attr('data-sonproject-index');
                    public_project_id = $(this).attr('data-project-id');
                    public_sontable_index = $(this).attr('data-project-id');
                    var data = $('#sonproject-table-' + public_sontable_index).bootstrapTable('getData');
                    public_sonproject_id = data[index].id;
                    $('#allot-son-project-name').val(data[index].name);
                    $('#allot-son-project-profession').val(data[index].profession_id);
                    $('#allot-son-project-cost').val(data[index].cost);
                    $('#allot-son-project-check-mark').val(data[index].check_mark);
                    $('#allot-son-project-checkcost').val(data[index].check_cost);
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

            $('#check-project-sum-cost').click(function(){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'getCostProjectMoney',
                    type: 'POST',
                    data: {
                        service_id: $('#check-project-service').val(),
                        cost: $('#check-project-cost').val(),
                        project_basic_rate: $('#check-project-basic-rate').val(),
                        min_profit: $('#check-project-min-profit').val(),
                        check_cost: $('#check-project-checkcost').val(),
                        project_check_rate: $('#check-project-check-rate').val(),
                        check_cost_rate: $('#check-project-check-cost-rate').val()
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
                                text: '费用计算成功',
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 6
                            });
                            $('#check-project-check-money').val(doc.data.check_money);
                            $('#check-project-service-fee').val(doc.data.service_money);
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

            $('#check-project-submit').click(function(){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'CostProjectCCheck',
                    type: 'POST',
                    data: {
                        project_id: public_project_id,
                        service_id: $('#check-project-service').val(),
                        cost: $('#check-project-cost').val(),
                        project_basic_rate: $('#check-project-basic-rate').val(),
                        min_profit: $('#check-project-min-profit').val(),
                        check_cost: $('#check-project-checkcost').val(),
                        project_check_rate: $('#check-project-check-rate').val(),
                        check_cost_rate: $('#check-project-check-cost-rate').val(),
                        check_mark: $('#check-project-checkmark').val()
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
                                text: '费用计算成功',
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 6
                            });
                            $('#checkProjectModal').modal('hide');
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

            $('#allot-son-project-submit').click(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'CostSonProjectCCheck',
                    type: 'POST',
                    data: {
                        sonproject_id: public_sonproject_id,
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

            $('#checkProjectModal').on('hide.bs.modal', function () {
                $('#sonproject-cost-table').bootstrapTable('destroy');
            });

            $('#addCpattachmentModal').on('hide.bs.modal', function () {
                $('#add-cpattachment-table').bootstrapTable('destroy');
            });

            $('#editProjectModal').on('hide.bs.modal', function () {
                $("input[name='edit-project-professions-checkbox-group']")
                    .map(function (index, elem) {
                        $(elem).prop("checked", false);
                    });
            });

            $('#editSonProjectModal').on('hide.bs.modal', function () {
                $('#edit-cspattachment-table').bootstrapTable('destroy');
            });

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