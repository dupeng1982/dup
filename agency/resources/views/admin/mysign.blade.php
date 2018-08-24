@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/calendar/dist/fullcalendar.css') }}" rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">考勤设置</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/index') }}">首页</a></li>
                <li class="breadcrumb-item active">我的考勤</li>
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
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-muted">我的考勤</h4>
                <div id="my-sign-calendar"></div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="sign-apply-event" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">补考勤</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>日期</label>
                            <input type="text" class="form-control" disabled="disabled"
                                   id="admin-sign-apply-date"></div>
                        <div class="form-group">
                            <label>类型</label>
                            <input type="text" class="form-control" disabled="disabled"
                                   id="admin-sign-apply-type"></div>
                        <div class="form-group">
                            <label>说明</label>
                            <textarea type="text" class="form-control"
                                      id="admin-sign-apply-description"></textarea></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="admin-sign-apply"
                            class="btn btn-success">提交
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="leave-event" tabindex="-1" role="dialog"
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
@endsection

@section('admin-js')
    <script src="{{ asset('admin/assets/plugins/calendar/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/moment/moment.js') }}"></script>
    <script src='{{ asset('admin/assets/plugins/calendar/dist/fullcalendar.min.js') }}'></script>
    <script src="{{ asset('admin/assets/plugins/calendar/dist/cal-sign.js') }}"></script>
    <script>
        $('#admin-sign-apply').click(function(){
            var sign_apply_date = $('#admin-sign-apply-date').val();
            var sign_apply_type = $('#admin-sign-apply-type').attr('data-sign-apply-type');
            var sign_apply_reason = $('#admin-sign-apply-description').val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'adminSignApply',
                type: 'POST',
                data: {
                    sign_apply_date: sign_apply_date,
                    sign_apply_type: sign_apply_type,
                    sign_apply_reason: sign_apply_reason
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
                        $('#sign-apply-event').modal('hide');
                        $('#my-sign-calendar').fullCalendar('refetchEvents');
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
    </script>
@endsection