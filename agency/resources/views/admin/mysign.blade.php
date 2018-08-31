@extends('layouts.admin')

@section('admin-css')
    <link href="{{ asset('admin/assets/plugins/calendar/dist/fullcalendar.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
          rel="stylesheet"/>
@endsection

@section('admin-title')
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">我的考勤</h3>
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
                            <label>补签说明</label>
                            <textarea type="text" class="form-control"
                                      id="admin-sign-apply-description"></textarea></div>
                        <div class="form-group">
                            <label>审核说明</label>
                            <textarea type="text" class="form-control" disabled
                                      id="admin-sign-apply-check-description"></textarea></div>
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
                    <h4 class="modal-title">请假</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>开始时间</label>
                            <input type="text" class="form-control"
                                   id="leave-start-time"></div>
                        <div class="form-group">
                            <label>结束时间</label>
                            <input type="text" class="form-control"
                                   id="leave-end-time"></div>
                        <div class="form-group">
                            <label>请假类型</label>
                            <div class="demo-radio-button">
                                <input name="leave_type_radio_group" type="radio" id="leave_type_1"
                                       class="with-gap radio-col-red" value="1"/>
                                <label for="leave_type_1">调休</label>
                                <input name="leave_type_radio_group" type="radio" id="leave_type_2"
                                       class="with-gap radio-col-brown" value="2"/>
                                <label for="leave_type_2">事假</label>
                                <input name="leave_type_radio_group" type="radio" id="leave_type_3"
                                       class="with-gap radio-col-orange" value="3"/>
                                <label for="leave_type_3">病假</label>
                                <input name="leave_type_radio_group" type="radio" id="leave_type_4"
                                       class="with-gap radio-col-blue" value="4"/>
                                <label for="leave_type_4">出差</label>
                                <input name="leave_type_radio_group" type="radio" id="leave_type_5"
                                       class="with-gap radio-col-yellow" value="5"/>
                                <label for="leave_type_5">下现场</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>请假原因</label>
                            <textarea type="text" class="form-control"
                                      id="leave-reason"></textarea></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" id="submit-leave-info"
                            class="btn btn-success">提交
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="leave-show-event" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">请假信息</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>申请时间</label>
                            <input type="text" class="form-control" disabled="disabled"
                                   id="leave-apply-time-show"></div>
                        <div class="form-group">
                            <label>开始时间</label>
                            <input type="text" class="form-control" disabled="disabled"
                                   id="leave-start-time-show"></div>
                        <div class="form-group">
                            <label>结束时间</label>
                            <input type="text" class="form-control" disabled="disabled"
                                   id="leave-end-time-show"></div>
                        <div class="form-group">
                            <label>请假类型</label>
                            <input type="text" class="form-control" disabled="disabled"
                                   id="leave-type-show"></div>
                        <div class="form-group">
                            <label>请假原因</label>
                            <textarea type="text" class="form-control" disabled="disabled"
                                      id="leave-reason-show"></textarea></div>
                        <div class="form-group">
                            <label>审核说明</label>
                            <textarea type="text" class="form-control" disabled
                                      id="leave-check-reason-show"></textarea></div>
                    </form>
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
    <script src="{{ asset('admin/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <script>
        $('#leave-start-time').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
        $('#leave-end-time').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm:ss'});
        $('#admin-sign-apply').click(function () {
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
        $('#submit-leave-info').click(function () {
            var leave_start_time = $('#leave-start-time').val();
            var leave_end_time = $('#leave-end-time').val();
            var leave_type = $("input[name='leave_type_radio_group']:checked").val();
            var leave_reason = $('#leave-reason').val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'adminAskForLeave',
                type: 'POST',
                data: {
                    leave_start_time: leave_start_time,
                    leave_end_time: leave_end_time,
                    leave_type: leave_type,
                    leave_reason: leave_reason
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
                        $('#leave-event').modal('hide');
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