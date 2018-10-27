@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/wizard/steps.css') }}" rel="stylesheet">
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
                           data-page-size="7" id="admin_info_table">
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal bs-example-modal-lg fade show" id="addAdminInfoModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">添加人员</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="validation">
                        <div class="col-12 wizard-content">
                            <form action="#" class="validation-wizard wizard-circle" id="addAdminInfoForm">
                                <!-- Step 1 -->
                                <h6>基本信息</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="username"> 用户名 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required"
                                                       id="username" name="username"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="realname"> 姓名 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="realname"
                                                       name="realname"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="adminsex"> 性别 : <span
                                                            class="danger">*</span> </label>
                                                <select class="custom-select form-control required"
                                                        id="adminsex" name="adminsex">
                                                    <option value="">选择性别</option>
                                                    <option value="1">男</option>
                                                    <option value="2">女</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="birthday"> 出生年月 : <span
                                                            class="danger">*</span> </label>
                                                <input type="date" class="form-control required"
                                                       id="birthday" name="birthday"
                                                       style="padding-top: 6px;padding-bottom: 6px;"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cardno"> 身份证号码 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required"
                                                       id="cardno" name="cardno"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="phone"> 手机号码 : <span
                                                            class="danger">*</span> </label>
                                                <input type="tel" class="form-control required" id="phone"
                                                       name="phone">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="address"> 现在住址 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required"
                                                       id="address" name="address"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="education"> 学历 : <span
                                                            class="danger">*</span> </label>
                                                <select class="custom-select form-control required"
                                                        id="education" name="education">
                                                    <option value="">选择学历</option>
                                                    @foreach($data['education'] as $v)
                                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="school"> 毕业院校 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="school"
                                                       name="school"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="major"> 所学专业 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="major"
                                                       name="major"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="graduate_date"> 毕业时间 : <span
                                                            class="danger">*</span> </label>
                                                <input type="date" class="form-control required"
                                                       id="graduate_date" name="graduate_date"></div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="work_year"> 工作年限 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="work_year"
                                                       name="work_year"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="level_id"> 所获职称 :</label>
                                                <select class="custom-select form-control"
                                                        id="level_id" name="level_id">
                                                    <option value="">选择职称</option>
                                                    @foreach($data['level'] as $v)
                                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="level_type"> 职称类别 :</label>
                                                <input type="text" class="form-control" id="level_type"
                                                       name="level_type"></div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 2 -->
                                <h6>职务信息</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="u-img">
                                                    <input type="file" class="dropify" id="admininfo-avatar"
                                                           data-show-remove="false" data-height="250"
                                                           data-max-file-size="1M"
                                                           data-allowed-file-extensions="jpg png"
                                                           data-default-file="{{ asset('admin/avatars/avatar.png') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="department"> 所属部门 : <span
                                                                    class="danger">*</span> </label>
                                                        <select class="custom-select form-control required"
                                                                id="department" name="department">
                                                            <option value="">选择部门</option>
                                                            @foreach($data['department'] as $v)
                                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="admin_level"> 行政职务 : <span
                                                                    class="danger">*</span> </label>
                                                        <select class="custom-select form-control required"
                                                                id="admin_level" name="admin_level">
                                                            <option value="">选择职务</option>
                                                            @foreach($data['admin_level'] as $v)
                                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="technical_level"> 人员类别 : <span
                                                                    class="danger">*</span> </label>
                                                        <select class="custom-select form-control required"
                                                                id="technical_level" name="technical_level">
                                                            <option value="">选择类别</option>
                                                            @foreach($data['technical_level'] as $v)
                                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="work_status"> 在职状态 : <span
                                                                    class="danger">*</span> </label>
                                                        <select class="custom-select form-control required"
                                                                id="work_status" name="work_status">
                                                            <option value="">选择类别</option>
                                                            @foreach($data['work_status'] as $v)
                                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="work_start_date"> 入职时间 : <span
                                                                    class="danger">*</span> </label>
                                                        <input type="date" class="form-control required"
                                                               id="work_start_date" name="work_start_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label> 专业类别 :</label>
                                                <div class="c-inputs-stacked">
                                                    <div class="row">
                                                        @foreach($data['professions'] as $v)
                                                            <div class="col-md-4">
                                                                <label class="inline custom-control custom-checkbox block">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           name="admin_professions_checkbox_group"
                                                                           id="admin_profession_{{ $v->id }}"
                                                                           value="{{ $v->id }}"> <span
                                                                            class="custom-control-indicator"></span>
                                                                    <span
                                                                            class="custom-control-description ml-0">{{ $v->name }}</span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark"> 备注 :</label>
                                                <textarea name="remark" id="remark"
                                                          rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 3 -->
                                <h6>工作及学习</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="work_resume"> 工作简历 :</label>
                                                <textarea name="work_resume" id="work_resume"
                                                          rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="study_resume"> 学习简历 :</label>
                                                <textarea name="study_resume" id="study_resume"
                                                          rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 4 -->
                                <h6>业绩及奖惩</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="performance"> 主要业绩 :</label>
                                                <textarea name="performance" id="performance"
                                                          rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="rewards"> 奖惩情况 :</label>
                                                <textarea name="rewards" id="rewards"
                                                          rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 5 -->
                                <h6>所获证书</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="certificate_name"> 证书名称 :</label>
                                                <input type="text" class="form-control" name="certificate_name"
                                                       id="certificate_name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="certificate_number"> 证书编号 :</label>
                                                <input type="text" class="form-control" name="certificate_number"
                                                       id="certificate_number">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="certificate_continue_password"> 延续注册密码 :</label>
                                                <input type="text" class="form-control"
                                                       name="certificate_continue_password"
                                                       id="certificate_continue_password">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="certificate_study_password"> 继续再教育密码 :</label>
                                                <input type="text" class="form-control"
                                                       name="certificate_study_password"
                                                       id="certificate_study_password">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="certificate_change_password"> 变更密码 :</label>
                                                <input type="text" class="form-control"
                                                       name="certificate_change_password"
                                                       id="certificate_change_password">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="add_tmp_certificate_info"> </label>
                                                <p>
                                                    <button type="button" id="add_tmp_certificate_info"
                                                            class="btn waves-effect waves-light btn-rounded btn-secondary"
                                                            style="top :10px;">
                                                        添加
                                                    </button>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-hover toggle-circle"
                                                   data-page-size="7" id="admin_certificate_table">
                                            </table>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 6 -->
                                <h6>家庭主要成员</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="family_name"> 姓名 :</label>
                                                <input type="text" class="form-control" name="family_name"
                                                       id="family_name">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="family_relation"> 关系 :</label>
                                                <input type="text" class="form-control" name="family_relation"
                                                       id="family_relation">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="family_phone"> 电话 :</label>
                                                <input type="text" class="form-control" name="family_phone"
                                                       id="family_phone">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="add_tmp_family_info"> </label>
                                                <p>
                                                    <button type="button" id="add_tmp_family_info"
                                                            class="btn waves-effect waves-light btn-rounded btn-secondary"
                                                            style="top :10px;">
                                                        添加
                                                    </button>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-hover toggle-circle"
                                                   data-page-size="7" id="admin_family_table">
                                            </table>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 7 -->
                                <h6>附件</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="admininfo_pic_name"> 名称 :</label>
                                                <input type="text" class="form-control" name="admininfo_pic_name"
                                                       id="admininfo_pic_name">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="admininfo_pic_dir"> 附件 :</label>
                                                <input type="file" class="form-control" id="admininfo_pic_dir"
                                                       multiple="multiple">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="add_tmp_admininfo_pic"> </label>
                                                <p>
                                                    <button type="button" id="add_tmp_admininfo_pic"
                                                            class="btn waves-effect waves-light btn-rounded btn-secondary"
                                                            style="top :10px;">
                                                        添加
                                                    </button>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-hover toggle-circle"
                                                   data-page-size="7" id="admininfo_pic_table">
                                            </table>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                                </section>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bs-example-modal-lg fade show" id="editAdminInfoModal" tabindex="-1" role="dialog"
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
                    <div class="row" id="edit-validation">
                        <div class="col-12 wizard-content">
                            <form action="#" class="validation-wizard wizard-circle" id="editAdminInfoForm">
                                <input type="hidden" class="form-control" id="edit-admininfo_id">
                                <!-- Step 1 -->
                                <h6>基本信息</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit-username"> 用户名 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required"
                                                       id="edit-username" name="username"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit-realname"> 姓名 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="edit-realname"
                                                       name="realname"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit-adminsex"> 性别 : <span
                                                            class="danger">*</span> </label>
                                                <select class="custom-select form-control required"
                                                        id="edit-adminsex" name="adminsex">
                                                    <option value="">选择性别</option>
                                                    <option value="1">男</option>
                                                    <option value="2">女</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edit-birthday"> 出生年月 : <span
                                                            class="danger">*</span> </label>
                                                <input type="date" class="form-control required"
                                                       id="edit-birthday" name="birthday"
                                                       style="padding-top: 6px;padding-bottom: 6px;"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edit-cardno"> 身份证号码 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required"
                                                       id="edit-cardno" name="cardno"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit-phone"> 手机号码 : <span
                                                            class="danger">*</span> </label>
                                                <input type="tel" class="form-control required" id="edit-phone"
                                                       name="phone">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="edit-address"> 现在住址 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required"
                                                       id="edit-address" name="address"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit-education"> 学历 : <span
                                                            class="danger">*</span> </label>
                                                <select class="custom-select form-control required"
                                                        id="edit-education" name="education">
                                                    <option value="">选择学历</option>
                                                    @foreach($data['education'] as $v)
                                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit-school"> 毕业院校 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="edit-school"
                                                       name="school"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit-major"> 所学专业 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="edit-major"
                                                       name="major"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit-graduate_date"> 毕业时间 : <span
                                                            class="danger">*</span> </label>
                                                <input type="date" class="form-control required"
                                                       id="edit-graduate_date" name="graduate_date"></div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="edit-work_year"> 工作年限 : <span
                                                            class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="edit-work_year"
                                                       name="work_year"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit-level_id"> 所获职称 :</label>
                                                <select class="custom-select form-control"
                                                        id="edit-level_id" name="level_id">
                                                    <option value="">选择职称</option>
                                                    @foreach($data['level'] as $v)
                                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit-level_type"> 职称类别 :</label>
                                                <input type="text" class="form-control" id="edit-level_type"
                                                       name="level_type"></div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 2 -->
                                <h6>职务信息</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="u-img">
                                                    <input type="file" class="dropify" id="edit-admininfo-avatar"
                                                           data-show-remove="false" data-height="250"
                                                           data-max-file-size="1M"
                                                           data-allowed-file-extensions="jpg png"
                                                           data-default-file="{{ asset('admin/avatars/avatar.png') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="edit-department"> 所属部门 : <span
                                                                    class="danger">*</span> </label>
                                                        <select class="custom-select form-control required"
                                                                id="edit-department" name="department">
                                                            <option value="">选择部门</option>
                                                            @foreach($data['department'] as $v)
                                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="edit-admin_level"> 行政职务 : <span
                                                                    class="danger">*</span> </label>
                                                        <select class="custom-select form-control required"
                                                                id="edit-admin_level" name="admin_level">
                                                            <option value="">选择职务</option>
                                                            @foreach($data['admin_level'] as $v)
                                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="edit-technical_level"> 人员类别 : <span
                                                                    class="danger">*</span> </label>
                                                        <select class="custom-select form-control required"
                                                                id="edit-technical_level" name="technical_level">
                                                            <option value="">选择类别</option>
                                                            @foreach($data['technical_level'] as $v)
                                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="edit-work_status"> 在职状态 : <span
                                                                    class="danger">*</span> </label>
                                                        <select class="custom-select form-control required"
                                                                id="edit-work_status" name="work_status">
                                                            <option value="">选择类别</option>
                                                            @foreach($data['work_status'] as $v)
                                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="edit-work_start_date"> 入职时间 : <span
                                                                    class="danger">*</span> </label>
                                                        <input type="date" class="form-control required"
                                                               id="edit-work_start_date" name="work_start_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label> 专业类别 :</label>
                                                <div class="c-inputs-stacked">
                                                    <div class="row">
                                                        @foreach($data['professions'] as $v)
                                                            <div class="col-md-4">
                                                                <label class="inline custom-control custom-checkbox block">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           name="edit-admin_professions_checkbox_group"
                                                                           id="edit-admin_profession_{{ $v->id }}"
                                                                           value="{{ $v->id }}"> <span
                                                                            class="custom-control-indicator"></span>
                                                                    <span
                                                                            class="custom-control-description ml-0">{{ $v->name }}</span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="edit-remark"> 备注 :</label>
                                                <textarea name="remark" id="edit-remark"
                                                          rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 3 -->
                                <h6>工作及学习</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="edit-work_resume"> 工作简历 :</label>
                                                <textarea name="work_resume" id="edit-work_resume"
                                                          rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="edit-study_resume"> 学习简历 :</label>
                                                <textarea name="study_resume" id="edit-study_resume"
                                                          rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 4 -->
                                <h6>业绩及奖惩</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="edit-performance"> 主要业绩 :</label>
                                                <textarea name="performance" id="edit-performance"
                                                          rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="edit-rewards"> 奖惩情况 :</label>
                                                <textarea name="rewards" id="edit-rewards"
                                                          rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 5 -->
                                <h6>所获证书</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edit-certificate_name"> 证书名称 :</label>
                                                <input type="text" class="form-control" name="certificate_name"
                                                       id="edit-certificate_name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edit-certificate_number"> 证书编号 :</label>
                                                <input type="text" class="form-control" name="certificate_number"
                                                       id="edit-certificate_number">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit-certificate_continue_password"> 延续注册密码 :</label>
                                                <input type="text" class="form-control"
                                                       name="certificate_continue_password"
                                                       id="edit-certificate_continue_password">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit-certificate_study_password"> 继续再教育密码 :</label>
                                                <input type="text" class="form-control"
                                                       name="certificate_study_password"
                                                       id="edit-certificate_study_password">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit-certificate_change_password"> 变更密码 :</label>
                                                <input type="text" class="form-control"
                                                       name="certificate_change_password"
                                                       id="edit-certificate_change_password">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit-add_tmp_certificate_info"> </label>
                                                <p>
                                                    <button type="button" id="edit-add_tmp_certificate_info"
                                                            class="btn waves-effect waves-light btn-rounded btn-secondary"
                                                            style="top :10px;">
                                                        添加
                                                    </button>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-hover toggle-circle"
                                                   data-page-size="7" id="edit-admin_certificate_table">
                                            </table>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 6 -->
                                <h6>家庭主要成员</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit-family_name"> 姓名 :</label>
                                                <input type="text" class="form-control" name="family_name"
                                                       id="edit-family_name">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit-family_relation"> 关系 :</label>
                                                <input type="text" class="form-control" name="family_relation"
                                                       id="edit-family_relation">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit-family_phone"> 电话 :</label>
                                                <input type="text" class="form-control" name="family_phone"
                                                       id="edit-family_phone">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="edit-add_tmp_family_info"> </label>
                                                <p>
                                                    <button type="button" id="edit-add_tmp_family_info"
                                                            class="btn waves-effect waves-light btn-rounded btn-secondary"
                                                            style="top :10px;">
                                                        添加
                                                    </button>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-hover toggle-circle"
                                                   data-page-size="7" id="edit-admin_family_table">
                                            </table>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 7 -->
                                <h6>附件</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="edit-admininfo_pic_name"> 名称 :</label>
                                                <input type="text" class="form-control" name="admininfo_pic_name"
                                                       id="edit-admininfo_pic_name">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="edit-admininfo_pic_dir"> 附件 :</label>
                                                <input type="file" class="form-control" id="edit-admininfo_pic_dir"
                                                       multiple="multiple">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="edit-add_tmp_admininfo_pic"> </label>
                                                <p>
                                                    <button type="button" id="edit-add_tmp_admininfo_pic"
                                                            class="btn waves-effect waves-light btn-rounded btn-secondary"
                                                            style="top :10px;">
                                                        添加
                                                    </button>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-hover toggle-circle"
                                                   data-page-size="7" id="edit-admininfo_pic_table">
                                            </table>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>
                                </section>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="confirmDelAdmin" tabindex="-1" role="dialog"
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
                    <button type="button" id="del-admin-info"
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
    <script src="{{ asset('admin/assets/plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/wizard/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/wizard/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/wizard/messages_zh.js') }}"></script>
    <script>
        $(function () {
            var del_admin_id;
            $('#admin_info_table').bootstrapTable({
                url: 'getAdminInfoList',
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
                    title: '姓名'
                }, {
                    field: 'sex_name',
                    title: '性别'
                }, {
                    field: 'cardno',
                    title: '身份证号'
                }, {
                    field: 'phone',
                    title: '手机号码'
                }, {
                    field: 'department_name',
                    title: '部门'
                }, {
                    field: 'admin_level_name',
                    title: '行政级别'
                }, {
                    field: 'technical_level_name',
                    title: '人员类别'
                }, {
                    field: 'level_name',
                    title: '技术职称'
                }, {
                    field: 'work_status_name',
                    title: '在职状态'
                }, {
                    field: 'professions',
                    title: '负责专业',
                    formatter: educationFormatter
                }, {
                    field: 'id',
                    title: '操作<button type="button" id="addAdminInfo" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="添加人员"><i class="ti-user" aria-hidden="true"></i></button>',
                    formatter: operateFormatter
                }],
                onPostBody: onPostBody
            });

            function educationFormatter(value, row, index) {
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

            function operateFormatter(value, row, index) {
                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn editAdminInfo" data-admininfo_id=' + index + ' data-toggle="tooltip" data-original-title="编辑"><i class="ti-marker-alt" aria-hidden="true"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delAdminInfo" data-admininfo_id=' + index + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
            }

            function refresh() {
                $('#admin_info_table').bootstrapTable('refresh', {url: 'getAdminInfoList'});
            }

            function refresh1() {
                $('#admin_family_table').bootstrapTable('refresh', {url: 'getAdminFamily'});
            }

            function refresh11() {
                $('#edit-admin_family_table').bootstrapTable('refresh', {url: 'getAdminFamilyInfo'});
            }

            function refresh2() {
                $('#admin_certificate_table').bootstrapTable('refresh', {url: 'getAdminCertificate'});
            }

            function refresh22() {
                $('#edit-admin_certificate_table').bootstrapTable('refresh', {url: 'getAdminCertificateInfo'});
            }

            function refresh3() {
                $('#admininfo_pic_table').bootstrapTable('refresh', {url: 'getAdmininfoPic'});
            }

            function refresh33() {
                $('#edit-admininfo_pic_table').bootstrapTable('refresh', {url: 'getAdmininfoPicInfo'});
            }

            function onPostBody(res) {
                $("[data-toggle='tooltip']").tooltip();

                $('#addAdminInfo').click(function () {
                    $('#addAdminInfoModal').modal('show');
                    $('#admin_family_table').bootstrapTable({
                        url: 'getAdminFamily',
                        ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                        cache: false,
                        method: 'POST',
                        contentType: "application/x-www-form-urlencoded",
                        dataField: "data",
                        pageNumber: 1,
                        pagination: true,
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
                            title: '姓名'
                        }, {
                            field: 'relation',
                            title: '关系'
                        }, {
                            field: 'phone',
                            title: '电话'
                        }, {
                            field: 'id',
                            title: '操作',
                            formatter: function (value, row, index) {
                                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delFamilyInfo" data-family-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                            }
                        }],
                        onPostBody: function (res) {
                            $('.delFamilyInfo').click(function () {
                                var family_id = $(this).attr('data-family-id');
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: 'delAdminFamily',
                                    type: 'POST',
                                    data: {
                                        family_id: family_id
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
                                            refresh1();
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
                        }
                    });
                    $('#admin_certificate_table').bootstrapTable({
                        url: 'getAdminCertificate',
                        ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                        cache: false,
                        method: 'POST',
                        contentType: "application/x-www-form-urlencoded",
                        dataField: "data",
                        pageNumber: 1,
                        pagination: true,
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
                            title: '证书名称'
                        }, {
                            field: 'number',
                            title: '编号'
                        }, {
                            field: 'continue_password',
                            title: '延续注册密码'
                        }, {
                            field: 'study_password',
                            title: '继续再教育密码'
                        }, {
                            field: 'change_password',
                            title: '变更密码'
                        }, {
                            field: 'id',
                            title: '操作',
                            formatter: function (value, row, index) {
                                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delCertificateInfo" data-certificate-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                            }
                        }],
                        onPostBody: function (res) {
                            $('.delCertificateInfo').click(function () {
                                var certificate_id = $(this).attr('data-certificate-id');
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: 'delAdminCertificate',
                                    type: 'POST',
                                    data: {
                                        certificate_id: certificate_id
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
                        }
                    });
                    $('#admininfo_pic_table').bootstrapTable({
                        url: 'getAdmininfoPic',
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
                                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn showAdminInfoPic" data-admininfo-pic-id=' + value + ' data-toggle="tooltip" data-original-title="查看"><i class="ti-eye" aria-hidden="true"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn downLoadAdminInfoPic" data-admininfo-pic-id=' + value + ' data-toggle="tooltip" data-original-title="下载"><i class="ti-save" aria-hidden="true"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delAdminInfoPic" data-admininfo-pic-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                            }
                        }],
                        onPostBody: function (res) {
                            $('.delAdminInfoPic').click(function () {
                                var admininfo_pic_id = $(this).attr('data-admininfo-pic-id');
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: 'delAdmininfoPic',
                                    type: 'POST',
                                    data: {
                                        admininfo_pic_id: admininfo_pic_id
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
                            $('.showAdminInfoPic').click(function () {
                                var admininfo_pic_id = $(this).attr('data-admininfo-pic-id');
                                window.open('showAdmininfoPic?admininfo_pic_id=' + admininfo_pic_id);
                            });
                            $('.downLoadAdminInfoPic').click(function () {
                                var admininfo_pic_id = $(this).attr('data-admininfo-pic-id');
                                window.open('downLoadAdmininfoPic?admininfo_pic_id=' + admininfo_pic_id);
                            });
                        }
                    });
                });

                $('#add_tmp_family_info').click(function () {
                    var family_name = $('#family_name').val();
                    var family_relation = $('#family_relation').val();
                    var family_phone = $('#family_phone').val();
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: 'addAdminFamily',
                        type: 'POST',
                        data: {
                            family_name: family_name,
                            family_relation: family_relation,
                            family_phone: family_phone
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
                                refresh1();
                                $('#family_name').val('');
                                $('#family_relation').val('');
                                $('#family_phone').val('');
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
                $('#edit-add_tmp_family_info').click(function () {
                    var family_name = $('#edit-family_name').val();
                    var family_relation = $('#edit-family_relation').val();
                    var family_phone = $('#edit-family_phone').val();
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: 'addAdminFamilyInfo',
                        type: 'POST',
                        data: {
                            admininfo_id: $('#edit-admininfo_id').val(),
                            family_name: family_name,
                            family_relation: family_relation,
                            family_phone: family_phone
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
                                refresh11();
                                $('#edit-family_name').val('');
                                $('#edit-family_relation').val('');
                                $('#edit-family_phone').val('');
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
                $('#add_tmp_certificate_info').click(function () {
                    var certificate_name = $('#certificate_name').val();
                    var certificate_number = $('#certificate_number').val();
                    var continue_password = $('#certificate_continue_password').val();
                    var study_password = $('#certificate_study_password').val();
                    var change_password = $('#certificate_change_password').val();
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: 'addAdminCertificate',
                        type: 'POST',
                        data: {
                            certificate_name: certificate_name,
                            certificate_number: certificate_number,
                            continue_password: continue_password,
                            study_password: study_password,
                            change_password: change_password
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
                                $('#certificate_name').val('');
                                $('#certificate_number').val('');
                                $('#certificate_continue_password').val('');
                                $('#certificate_study_password').val('');
                                $('#certificate_change_password').val('');
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
                $('#edit-add_tmp_certificate_info').click(function () {
                    var certificate_name = $('#edit-certificate_name').val();
                    var certificate_number = $('#edit-certificate_number').val();
                    var continue_password = $('#edit-certificate_continue_password').val();
                    var study_password = $('#edit-certificate_study_password').val();
                    var change_password = $('#edit-certificate_change_password').val();
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: 'addAdminCertificateInfo',
                        type: 'POST',
                        data: {
                            admininfo_id: $('#edit-admininfo_id').val(),
                            certificate_name: certificate_name,
                            certificate_number: certificate_number,
                            continue_password: continue_password,
                            study_password: study_password,
                            change_password: change_password
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
                                refresh22();
                                $('#edit-certificate_name').val('');
                                $('#edit-certificate_number').val('');
                                $('#edit-certificate_continue_password').val('');
                                $('#edit-certificate_study_password').val('');
                                $('#edit-certificate_change_password').val('');
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
                $('#add_tmp_admininfo_pic').click(function () {
                    var admininfo_pic_name = $('#admininfo_pic_name').val();
                    //初始化FormData对象
                    var formData = new FormData();
                    var file = $("#admininfo_pic_dir").prop("files");
                    var n = file.length;
                    for (var i = 0; i < n; i++) {
                        formData.append("files[]", file[i]);
                    }
                    formData.append("admininfo_pic_name", admininfo_pic_name);
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: 'addAdmininfoPic',
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
                                refresh3();
                                $('#admininfo_pic_name').val('');
                                $("#admininfo_pic_dir").val('')
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
                $('#edit-add_tmp_admininfo_pic').click(function () {
                    var admininfo_pic_name = $('#edit-admininfo_pic_name').val();
                    //初始化FormData对象
                    var formData = new FormData();
                    var file = $("#edit-admininfo_pic_dir").prop("files");
                    var n = file.length;
                    for (var i = 0; i < n; i++) {
                        formData.append("files[]", file[i]);
                    }
                    formData.append("admininfo_pic_name", admininfo_pic_name);
                    formData.append("admininfo_id", $('#edit-admininfo_id').val());
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: 'addAdmininfoPicInfo',
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
                                refresh33();
                                $('#edit-admininfo_pic_name').val('');
                                $("#edit-admininfo_pic_dir").val('')
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

                $('.editAdminInfo').click(function () {
                    $('#editAdminInfoModal').modal('show');

                    var data = $('#admin_info_table').bootstrapTable('getData');
                    var index = $(this).attr('data-admininfo_id');
                    var admininfo_id = data[index].id;
                    $('#edit-admininfo_id').val(admininfo_id);
                    $('#edit-username').val(data[index].username);
                    $('#edit-realname').val(data[index].name);
                    $('#edit-birthday').val(data[index].birthday);
                    $('#edit-cardno').val(data[index].cardno);
                    $('#edit-phone').val(data[index].phone);
                    $('#edit-address').val(data[index].address);
                    $('#edit-school').val(data[index].school);
                    $('#edit-major').val(data[index].major);
                    $('#edit-graduate_date').val(data[index].graduate_date);
                    $('#edit-work_year').val(data[index].work_year);
                    $('#edit-level_type').val(data[index].level_type);
                    $('#edit-work_start_date').val(data[index].work_start_date);
                    //textarea
                    $('#edit-remark').val(data[index].remark);
                    $('#edit-work_resume').val(data[index].work_resume);
                    $('#edit-study_resume').val(data[index].study_resume);
                    $('#edit-performance').val(data[index].performance);
                    $('#edit-rewards').val(data[index].rewards);
                    //select
                    $('#edit-adminsex').val(data[index].sex);
                    $('#edit-education').val(data[index].education_id);
                    $('#edit-level_id').val(data[index].level_id);
                    $('#edit-department').val(data[index].department_id);
                    $('#edit-admin_level').val(data[index].admin_level_id);
                    $('#edit-technical_level').val(data[index].technical_level_id);
                    $('#edit-work_status').val(data[index].work_status);
                    //checkbox
                    data[index].professions.map(function (value, index, array) {
                        $("#edit-admin_profession_" + value.id).attr("checked", "checked");
                    });
                    var admininfo_avatar;
                    if (data[index].avatar) {
                        admininfo_avatar = "getAdminAvatar" + data[index].avatar;
                    } else {
                        admininfo_avatar = "getAdminAvatar/0/0";
                    }
                    $('#edit-admininfo-avatar').siblings('.dropify-preview')
                        .children('.dropify-render').children('img')
                        .attr('src', admininfo_avatar);

                    $('#edit-admin_family_table').bootstrapTable({
                        url: 'getAdminFamilyInfo',
                        ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                        cache: false,
                        method: 'POST',
                        contentType: "application/x-www-form-urlencoded",
                        dataField: "data",
                        pageNumber: 1,
                        pagination: true,
                        search: false,
                        sidePagination: 'client',
                        pageSize: 5,//单页记录数
                        queryParams: function (params) {
                            return {
                                admininfo_id: $('#edit-admininfo_id').val()
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
                            title: '姓名'
                        }, {
                            field: 'relation',
                            title: '关系'
                        }, {
                            field: 'phone',
                            title: '电话'
                        }, {
                            field: 'id',
                            title: '操作',
                            formatter: function (value, row, index) {
                                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delEditFamilyInfo" data-family-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                            }
                        }],
                        onPostBody: function (res) {
                            $('.delEditFamilyInfo').click(function () {
                                var family_id = $(this).attr('data-family-id');
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: 'delAdminFamily',
                                    type: 'POST',
                                    data: {
                                        family_id: family_id
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
                                            refresh11();
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
                        }
                    });

                    $('#edit-admin_certificate_table').bootstrapTable({
                        url: 'getAdminCertificateInfo',
                        ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                        cache: false,
                        method: 'POST',
                        contentType: "application/x-www-form-urlencoded",
                        dataField: "data",
                        pageNumber: 1,
                        pagination: true,
                        search: false,
                        sidePagination: 'client',
                        pageSize: 5,//单页记录数
                        queryParams: function (params) {
                            return {
                                admininfo_id: $('#edit-admininfo_id').val()
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
                            title: '证书名称'
                        }, {
                            field: 'number',
                            title: '编号'
                        }, {
                            field: 'continue_password',
                            title: '延续注册密码'
                        }, {
                            field: 'study_password',
                            title: '继续再教育密码'
                        }, {
                            field: 'change_password',
                            title: '变更密码'
                        }, {
                            field: 'id',
                            title: '操作',
                            formatter: function (value, row, index) {
                                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delEditCertificateInfo" data-certificate-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                            }
                        }],
                        onPostBody: function (res) {
                            $('.delEditCertificateInfo').click(function () {
                                var certificate_id = $(this).attr('data-certificate-id');
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: 'delAdminCertificate',
                                    type: 'POST',
                                    data: {
                                        certificate_id: certificate_id
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
                                            refresh22();
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
                        }
                    });

                    $('#edit-admininfo_pic_table').bootstrapTable({
                        url: 'getAdmininfoPicInfo',
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
                                admininfo_id: $('#edit-admininfo_id').val()
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
                                return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn showEditAdminInfoPic" data-admininfo-pic-id=' + value + ' data-toggle="tooltip" data-original-title="查看"><i class="ti-eye" aria-hidden="true"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn downLoadEditAdminInfoPic" data-admininfo-pic-id=' + value + ' data-toggle="tooltip" data-original-title="下载"><i class="ti-save" aria-hidden="true"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn delEditAdminInfoPic" data-admininfo-pic-id=' + value + ' data-toggle="tooltip" data-original-title="删除"><i class="ti-close" aria-hidden="true"></i></button>';
                            }
                        }],
                        onPostBody: function (res) {
                            $('.delEditAdminInfoPic').click(function () {
                                var admininfo_pic_id = $(this).attr('data-admininfo-pic-id');
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: 'delAdmininfoPic',
                                    type: 'POST',
                                    data: {
                                        admininfo_pic_id: admininfo_pic_id
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
                                            refresh33();
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

                            $('.showEditAdminInfoPic').click(function () {
                                var admininfo_pic_id = $(this).attr('data-admininfo-pic-id');
                                window.open('showAdmininfoPic?admininfo_pic_id=' + admininfo_pic_id);
                            });
                            $('.downLoadEditAdminInfoPic').click(function () {
                                var admininfo_pic_id = $(this).attr('data-admininfo-pic-id');
                                window.open('downLoadAdmininfoPic?admininfo_pic_id=' + admininfo_pic_id);
                            });
                        }
                    });
                });

                $('.delAdminInfo').click(function () {
                    $('#confirmDelAdmin').modal('show');

                    var data = $('#admin_info_table').bootstrapTable('getData');
                    var index = $(this).attr('data-admininfo_id');
                    del_admin_id = data[index].admin_id;
                });
            }

            $('#del-admin-info').click(function(){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'delAdmin',
                    type: 'POST',
                    data: {
                        admin_id: del_admin_id
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
                            $('#confirmDelAdmin').modal('hide');
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

            $('#addAdminInfoModal').on('hide.bs.modal', function () {
                $('#admin_family_table').bootstrapTable('destroy');
                $('#admin_certificate_table').bootstrapTable('destroy');
                $('#admininfo_pic_table').bootstrapTable('destroy');
            });

            $('#editAdminInfoModal').on('hide.bs.modal', function () {
                $("input[name='edit-admin_professions_checkbox_group']")
                    .map(function (index, elem) {
                        $(elem).removeAttr('checked');
                    });
                $('#edit-admin_family_table').bootstrapTable('destroy');
                $('#edit-admin_certificate_table').bootstrapTable('destroy');
                $('#edit-admininfo_pic_table').bootstrapTable('destroy');
            });

            function clearModalInput() {
                $("#addAdminInfoForm")[0].reset();
                $('#admininfo-avatar').siblings('.dropify-preview')
                    .children('.dropify-render').children('img')
                    .attr('src', "{{ asset('admin/avatars/avatar.png') }}");
            }

            //添加人员信息
            var form = $("#addAdminInfoForm").show();

            $("#addAdminInfoForm").steps({
                headerTag: "h6",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    next: "下一步",
                    previous: "上一步",
                    finish: "提交"
                },
                onStepChanging: function (event, currentIndex, newIndex) {
                    return currentIndex > newIndex || (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
                },
                onFinishing: function (event, currentIndex) {
                    return form.validate().settings.ignore = ":disabled", form.valid()
                },
                onFinished: function (event, currentIndex) {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: 'addAdminInfo',
                        type: 'POST',
                        data: {
                            //input
                            username: $('#username').val(),
                            realname: $('#realname').val(),
                            birthday: $('#birthday').val(),
                            cardno: $('#cardno').val(),
                            phone: $('#phone').val(),
                            address: $('#address').val(),
                            school: $('#school').val(),
                            major: $('#major').val(),
                            graduate_date: $('#graduate_date').val(),
                            work_year: $('#work_year').val(),
                            level_type: $('#level_type').val(),
                            work_start_date: $('#work_start_date').val(),
                            //textarea
                            remark: $('#remark').val(),
                            work_resume: $('#work_resume').val(),
                            study_resume: $('#study_resume').val(),
                            performance: $('#performance').val(),
                            rewards: $('#rewards').val(),
                            //select
                            adminsex: $('#adminsex').val(),
                            education_id: $('#education').val(),
                            level_id: $('#level_id').val(),
                            department_id: $('#department').val(),
                            admin_level_id: $('#admin_level').val(),
                            technical_level_id: $('#technical_level').val(),
                            work_status: $('#work_status').val(),
                            //checkbox
                            admin_profession: $("input[name='admin_professions_checkbox_group']:checked")
                                .map(function (index, elem) {
                                    return $(elem).val();
                                }).get(),
                            avatar: $('#admininfo-avatar').siblings('.dropify-preview')
                                .children('.dropify-render').children('img')
                                .attr('src')
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
                                clearModalInput();
                                $('#addAdminInfoModal').modal('hide');
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
                }
            }),
                $("#addAdminInfoForm").validate({
                    ignore: "input[type=hidden]",
                    errorClass: "text-danger",
                    successClass: "text-success",
                    highlight: function (element, errorClass) {
                        $(element).removeClass(errorClass)
                    },
                    unhighlight: function (element, errorClass) {
                        $(element).removeClass(errorClass)
                    },
                    errorPlacement: function (error, element) {
                        error.insertAfter(element)
                    }
                });
            //编辑人员信息
            var form1 = $("#editAdminInfoForm").show();

            $("#editAdminInfoForm").steps({
                headerTag: "h6",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    next: "下一步",
                    previous: "上一步",
                    finish: "提交"
                },
                onStepChanging: function (event, currentIndex, newIndex) {
                    return currentIndex > newIndex || (currentIndex < newIndex && (form1.find(".body:eq(" + newIndex + ") label.error").remove(), form1.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form1.validate().settings.ignore = ":disabled,:hidden", form1.valid())
                },
                onFinishing: function (event, currentIndex) {
                    return form1.validate().settings.ignore = ":disabled", form1.valid()
                },
                onFinished: function (event, currentIndex) {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: 'editAdminInfo',
                        type: 'POST',
                        data: {
                            admininfo_id: $('#edit-admininfo_id').val(),
                            //input
                            username: $('#edit-username').val(),
                            realname: $('#edit-realname').val(),
                            birthday: $('#edit-birthday').val(),
                            cardno: $('#edit-cardno').val(),
                            phone: $('#edit-phone').val(),
                            address: $('#edit-address').val(),
                            school: $('#edit-school').val(),
                            major: $('#edit-major').val(),
                            graduate_date: $('#edit-graduate_date').val(),
                            work_year: $('#edit-work_year').val(),
                            level_type: $('#edit-level_type').val(),
                            work_start_date: $('#edit-work_start_date').val(),
                            //textarea
                            remark: $('#edit-remark').val(),
                            work_resume: $('#edit-work_resume').val(),
                            study_resume: $('#edit-study_resume').val(),
                            performance: $('#edit-performance').val(),
                            rewards: $('#edit-rewards').val(),
                            //select
                            adminsex: $('#edit-adminsex').val(),
                            education_id: $('#edit-education').val(),
                            level_id: $('#edit-level_id').val(),
                            department_id: $('#edit-department').val(),
                            admin_level_id: $('#edit-admin_level').val(),
                            technical_level_id: $('#edit-technical_level').val(),
                            work_status: $('#edit-work_status').val(),
                            //checkbox
                            admin_profession: $("input[name='edit-admin_professions_checkbox_group']:checked")
                                .map(function (index, elem) {
                                    return $(elem).val();
                                }).get(),
                            avatar: $('#edit-admininfo-avatar').siblings('.dropify-preview')
                                .children('.dropify-render').children('img')
                                .attr('src')
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
                                $('#editAdminInfoModal').modal('hide');
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
                }
            }),
                $("#editAdminInfoForm").validate({
                    ignore: "input[type=hidden]",
                    errorClass: "text-danger",
                    successClass: "text-success",
                    highlight: function (element, errorClass) {
                        $(element).removeClass(errorClass)
                    },
                    unhighlight: function (element, errorClass) {
                        $(element).removeClass(errorClass)
                    },
                    errorPlacement: function (error, element) {
                        error.insertAfter(element)
                    }
                });

        })
    </script>
@endsection