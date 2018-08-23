!function ($) {
    "use strict";
    var CalendarApp = function () {
        this.$body = $("body"),
            this.$calendar = $('#calendar'),
            this.$calendarObj = null
    };
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
                                order: $(this).attr('order')
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
            selectOverlap: false,
            editable: false,
            droppable: false,
            eventLimit: false,
            selectable: false,
            eventOrder: 'order'
        });
    },
        $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
}(window.jQuery),
//initializing CalendarApp
    function ($) {
        "use strict";
        $.CalendarApp.init();
    }(window.jQuery);