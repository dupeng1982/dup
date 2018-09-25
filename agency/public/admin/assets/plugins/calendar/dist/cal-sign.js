!function ($) {
    "use strict";
    var CalendarApp = function () {
        this.$body = $("body"),
            this.$calendar = $('#my-sign-calendar'),
            this.$modal = $('#sign-apply-event'),
            this.$modal1 = $('#leave-event'),
            this.$modal2 = $('#leave-show-event'),
            this.$calendarObj = null
    };
    CalendarApp.prototype.onSelect = function (start, end, allDay) {
        var $this = this;
        $this.$modal1.modal({
            backdrop: 'static'
        });
        var leave_start_time = $.fullCalendar.formatDate(start, 'YYYY-MM-DD HH:mm:ss');
        var leave_end_time = $.fullCalendar.formatDate(end.clone().add(-1, 'seconds'), 'YYYY-MM-DD HH:mm:ss');

        $this.$modal1.find('#leave-start-time').val(leave_start_time);
        $this.$modal1.find('#leave-end-time').val(leave_end_time);
    },
        CalendarApp.prototype.onEventClick = function (calEvent, jsEvent, view) {
            var $this = this;
            $this.$modal.modal({
                backdrop: 'static'
            });
            $this.$modal.find('#admin-sign-apply-date').val($.fullCalendar.formatDate(calEvent.start, 'YYYY-MM-DD'));
            var sign_apply_type;
            var sign_apply_reason;
            if (calEvent.order == 2) {
                sign_apply_type = '补签到';
            } else if (calEvent.order == 3) {
                sign_apply_type = '补签退';
            }
            $this.$modal.find('#admin-sign-apply-type').val(sign_apply_type).attr('data-sign-apply-type', calEvent.order - 1);
            if (calEvent.apply_reason) {
                sign_apply_reason = calEvent.apply_reason;
            } else {
                sign_apply_reason = '';
            }
            $this.$modal.find('#admin-sign-apply-description').val(sign_apply_reason);
            $this.$modal.find('#admin-sign-apply-check-description').val(calEvent.check_reason);
        },
        CalendarApp.prototype.onEventClick2 = function (calEvent, jsEvent, view) {
            var $this = this;
            $this.$modal2.modal({
                backdrop: 'static'
            });
            var leave_info = calEvent.leave_info;
            $this.$modal2.find('#leave-apply-time-show').val(leave_info.submit_time);
            $this.$modal2.find('#leave-start-time-show').val(leave_info.leave_start_time);
            $this.$modal2.find('#leave-end-time-show').val(leave_info.leave_end_time);
            $this.$modal2.find('#leave-type-show').val(leave_info.leave_type_name);
            $this.$modal2.find('#leave-reason-show').val(leave_info.leave_reason);
            $this.$modal2.find('#leave-check-reason-show').val(leave_info.approval_note);
        },
        /* Initializing */
        CalendarApp.prototype.init = function () {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var form = '';
            var today = new Date($.now());
            var defaultEvents = function (start, end, timezone, callback) {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'getMySign',
                    type: 'POST',
                    data: {
                        start_date: $.fullCalendar.formatDate(start, 'YYYY-MM-DD'),
                        end_date: $.fullCalendar.formatDate(end, 'YYYY-MM-DD')
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
                            var events = [];
                            $(doc.data).each(function () {
                                events.push({
                                    title: $(this).attr('title'),
                                    start: $(this).attr('start'),
                                    className: $(this).attr('className'),
                                    order: $(this).attr('order'),
                                    apply_reason: $(this).attr('apply_reason'),
                                    leave_info: $(this).attr('leave_info'),
                                    check_reason: $(this).attr('approval_note')
                                });
                            });
                            callback(events);
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
            };
            var $this = this;
            $this.$calendarObj = $this.$calendar.fullCalendar({
                height: 664,
                firstDay: 1,
                defaultView: 'month',
                handleWindowResize: true,
                monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                monthNamesShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                dayNames: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
                dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
                weekNumberTitle: "周",
                titleFormat: "YYYY年 MMMM",
                header: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                events: defaultEvents,
                selectOverlap: true,
                editable: false,
                droppable: false,
                eventLimit: false,
                selectable: true,
                eventOrder: 'order',

                eventClick: function (calEvent, jsEvent, view) {
                    if (((calEvent.order == 2) || (calEvent.order == 3)) && (calEvent.className[0] == 'bg-danger') &&
                        (calEvent.title != '待签到 ') && (calEvent.title != '待签退 ')) {
                        $this.onEventClick(calEvent, jsEvent, view);
                    }
                    if (calEvent.order == 4) {
                        $this.onEventClick2(calEvent, jsEvent, view);
                    }
                },
                select: function (start, end, allDay) {
                    $this.onSelect(start, end, allDay);
                }
            });
        },
        $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
}
(window.jQuery),
//initializing CalendarApp
    function ($) {
        "use strict";
        $.CalendarApp.init();
    }(window.jQuery);