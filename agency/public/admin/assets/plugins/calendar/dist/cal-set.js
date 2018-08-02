!function ($) {
    "use strict";
    var CalendarApp = function () {
        this.$body = $("body"),
            this.$calendar = $('#calendar'),
            this.$calendarObj = null
    };
    /* on click on event */
    CalendarApp.prototype.onEventClick = function (calEvent, jsEvent, view) {
        var start_date = $.fullCalendar.formatDate(calEvent.start, 'YYYY-MM-DD');
        var end_date = null;
        if (calEvent.end) {
            end_date = $.fullCalendar.formatDate(calEvent.end, 'YYYY-MM-DD');
        }else{
            end_date = start_date;
        }
        var $this = this;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'delDateEvent',
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date
            },
            success: function (doc) {
                if (doc.code) {
                    $.toast({
                        heading: '警告',
                        text: '设置失败，请重试！',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'warning',
                        hideAfter: 3000,
                        stack: 6
                    });
                } else {
                    $this.$calendarObj.fullCalendar('removeEvents', function (ev) {
                        return (ev._id == calEvent._id);
                    });
                    $.toast({
                        heading: '成功',
                        text: '删除成功！',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 3000,
                        stack: 6
                    });
                }
            },
            error: function (doc) {
                $.toast({
                    heading: '错误',
                    text: '系统错误！',
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3000,
                    stack: 6
                });
            }
        });
    },
        /* on select */
        CalendarApp.prototype.onSelect = function (start, end, allDay) {
            var $this = this;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'setDateEvent',
                type: 'POST',
                data: {
                    start_date: $.fullCalendar.formatDate(start, 'YYYY-MM-DD'),
                    end_date: $.fullCalendar.formatDate(end, 'YYYY-MM-DD')
                },
                success: function (doc) {
                    if (doc.code) {
                        $.toast({
                            heading: '警告',
                            text: '设置失败，请重试！',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'warning',
                            hideAfter: 3000,
                            stack: 6
                        });
                    } else {
                        $this.$calendarObj.fullCalendar('renderEvent', {
                            title: '休',
                            start: start,
                            end: end
                        }, true);
                        $this.$calendarObj.fullCalendar('unselect');
                        $.toast({
                            heading: '成功',
                            text: '设置成功！',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 6
                        });
                    }
                },
                error: function (doc) {
                    $.toast({
                        heading: '错误',
                        text: '系统错误！',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 3000,
                        stack: 6
                    });
                }
            });
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
                    url: 'getDateEvent',
                    type: 'POST',
                    data: {
                        start_date: $.fullCalendar.formatDate(start, 'YYYY-MM-DD'),
                        end_date: $.fullCalendar.formatDate(end, 'YYYY-MM-DD')
                    },
                    success: function (doc) {
                        if (doc.code) {
                            $.toast({
                                heading: '警告',
                                text: '数据获取失败，请刷新重试！',
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
                                    title: '休',
                                    start: $(this).attr('set_date')
                                });
                            });
                            callback(events);
                        }
                    },
                    error: function (doc) {
                        $.toast({
                            heading: '错误',
                            text: '系统错误！',
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
                height: 700,
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
                selectOverlap: false,
                editable: false,
                droppable: true,
                eventLimit: false,
                selectable: true,
                select: function (start, end, allDay) {
                    $this.onSelect(start, end, allDay);
                },
                eventClick: function (calEvent, jsEvent, view) {
                    $this.onEventClick(calEvent, jsEvent, view);
                }
            });
        },
        $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
}(window.jQuery),
//initializing CalendarApp
    function ($) {
        "use strict";
        $.CalendarApp.init()
    }(window.jQuery);