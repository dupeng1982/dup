@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">我的信息</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">我的信息</li>
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
        <div class="col-lg-12 col-xlg-12 col-md-12">
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#admin_base_info"
                                            role="tab">基本信息</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#work_study_info"
                                            role="tab">工作及学习</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reward_punishment_info"
                                            role="tab">业绩及奖惩</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#certificate_info"
                                            role="tab">所获证书</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#family_info" role="tab">家庭主要成员</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#attachment_info" role="tab">附件</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="admin_base_info" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 col-xs-4">
                                    <div class="u-img">
                                        <img src="getMyAvatar" class="img-responsive"
                                             alt="">
                                    </div>
                                </div>
                                <div class="col-md-10 col-xs-20">
                                    <div class="row">
                                        <div class="col-md-2 col-xs-4 b-l b-r"><strong>所属部门</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->department_name }}</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4 b-r"><strong>行政职务</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->admin_level_name }}</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4 b-r"><strong>人员类别</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->technical_level_name }}</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4 b-r"><strong>专业类别</strong>
                                            <br>
                                            <p class="text-muted">{{ implode(',',$data->professions->pluck('name')->toArray()) }}</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4"><strong>入职时间</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->work_start_date }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2 col-xs-4 b-l b-r"><strong>姓名</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->name }}</p>
                                        </div>
                                        <div class="col-md-1 col-xs-2 b-r"><strong>性别</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->sex_name }}</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4 b-r"><strong>出生年月</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->birthday }}</p>
                                        </div>
                                        <div class="col-md-3 col-xs-6 b-r"><strong>身份证号码</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->cardno }}</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4"><strong>在职状态</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->work_status_name }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2 col-xs-4 b-l b-r"><strong>最高学历</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->education_name }}</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4 b-r"><strong>毕业院校</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->school }}</p>
                                        </div>
                                        <div class="col-md-4 col-xs-8 b-r"><strong>所学专业</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->major }}</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4"><strong>毕业时间</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->graduate_date }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2 col-xs-4 b-l b-r"><strong>所获职称</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->level_name }}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-12 b-r"><strong>职称类别</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->level_type }}</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4"><strong>工作年限</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->work_year }}年</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2 col-xs-4 b-l b-r"><strong>手机号码</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->phone }}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-12 b-r"><strong>现在住址</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->address }}</p>
                                        </div>
                                        <div class="col-md-2 col-xs-4"><strong>备注</strong>
                                            <br>
                                            <p class="text-muted">{{ $data->remark }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="work_study_info" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-1 col-xs-2 b-r"><strong>工作简历</strong>
                                    <br>
                                </div>
                                <div class="col-md-11 col-xs-22">
                                    <pre class="text-muted">
{{ $data->work_resume }}
                                    </pre>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-1 col-xs-2 b-r"><strong>学习简历</strong>
                                    <br>
                                </div>
                                <div class="col-md-11 col-xs-22">
                                    <pre class="text-muted">
{{ $data->study_resume }}
                                    </pre>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="tab-pane" id="reward_punishment_info" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-1 col-xs-2 b-r"><strong>主要业绩</strong>
                                    <br>
                                </div>
                                <div class="col-md-11 col-xs-22">
                                    <pre class="text-muted">
{{ $data->performance }}
                                    </pre>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-1 col-xs-2 b-r"><strong>奖惩情况</strong>
                                    <br>
                                </div>
                                <div class="col-md-11 col-xs-22">
                                    <pre class="text-muted">
{{ $data->rewards }}
                                    </pre>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="tab-pane" id="certificate_info" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="my-certificate-table"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="family_info" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="my-family-table"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="attachment_info" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="my-admininfo-pic-table"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-table/dist/locale/bootstrap-table-zh-CN.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script>
        $(function () {
            $('#my-family-table').bootstrapTable({
                url: 'getMyFamilyInfo',
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
                    title: '姓名'
                }, {
                    field: 'relation',
                    title: '关系'
                }, {
                    field: 'phone',
                    title: '电话'
                }]
            });

            $('#my-certificate-table').bootstrapTable({
                url: 'getMyCertificateInfo',
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
                }]
            });

            $('#my-admininfo-pic-table').bootstrapTable({
                url: 'getMyAttachmentInfo',
                ajaxOptions: {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}},
                cache: false,
                method: 'POST',
                contentType: "application/x-www-form-urlencoded",
                dataField: "data",
                pageNumber: 1,
                pagination: false,
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
                        return '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn showMyAdminInfoPic" data-admininfo-pic-id=' + value + ' data-toggle="tooltip" data-original-title="查看"><i class="ti-eye" aria-hidden="true"></i></button>' +
                            '<button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn downLoadMyAdminInfoPic" data-admininfo-pic-id=' + value + ' data-toggle="tooltip" data-original-title="下载"><i class="ti-save" aria-hidden="true"></i></button>';
                    }
                }],
                onPostBody: function (res) {
                    $("[data-toggle='tooltip']").tooltip();
                    $('.showMyAdminInfoPic').click(function () {
                        var admininfo_pic_id = $(this).attr('data-admininfo-pic-id');
                        window.open('showMyPic?admininfo_pic_id=' + admininfo_pic_id);
                    });
                    $('.downLoadMyAdminInfoPic').click(function () {
                        var admininfo_pic_id = $(this).attr('data-admininfo-pic-id');
                        window.open('downLoadMyPic?admininfo_pic_id=' + admininfo_pic_id);
                    });
                }
            });
        });
    </script>
@endsection