<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="金信造价咨询">
    <meta name="author" content="dupeng">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/assets/images/favicon.png') }}">
    <title>{{ config('app.name', '金信造价咨询') }}</title>
    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
    @yield('admin-css')
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/colors/blue.css') }}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('admin/js/html5shiv.js') }}"></script>
    <script src="{{ asset('admin/js/respond.min.js') }}"></script>
    <![endif]-->
</head>

<body class="fix-header card-no-border">
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
<div id="main-wrapper">
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('admin/index') }}">
                    <b>
                        <img src="{{ asset('admin/assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo"/>
                        <img src="{{ asset('admin/assets/images/logo-light-icon.png') }}" alt="homepage"
                             class="light-logo"/>
                    </b>
                    <span>
                        <img src="{{ asset('admin/assets/images/logo-text.png') }}" alt="homepage" class="dark-logo"/>
                        <img src="{{ asset('admin/assets/images/logo-light-text.png') }}" class="light-logo"
                             alt="homepage"/></span>
                </a>
            </div>
            <div class="navbar-collapse">
                <ul class="navbar-nav mr-auto mt-md-0">
                    <li class="nav-item"><a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark"
                                            href="javascript:void(0)"><i class="mdi mdi-menu"></i></a></li>
                    <li class="nav-item"><a
                                class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark"
                                href="javascript:void(0)"><i class="ti-menu"></i></a></li>
                </ul>
                <ul class="navbar-nav my-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                    class="mdi mdi-message"></i>
                            @if(Auth::guard('admin')->user()->project_info || Auth::guard('admin')->user()->sonproject_info)
                                <div class="notify"><span class="heartbit"></span> <span class="point"></span></div>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                            <ul>
                                <li>
                                    <div class="drop-title">
                                        @if(Auth::guard('admin')->user()->project_info || Auth::guard('admin')->user()->sonproject_info)
                                            待办事项
                                        @else
                                            您暂时没有需要办理的业务！
                                        @endif
                                    </div>
                                </li>
                                <li>
                                    <div class="message-center">
                                        @foreach(Auth::guard('admin')->user()->project_info as $value)
                                            @if($value == 3)
                                                <a href="/admin/costprojectcheck">
                                                    <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i>
                                                    </div>
                                                    <div class="mail-contnet"><h5>您有项目审核业务，点击前往</h5></div>
                                                </a>
                                            @elseif($value == 4)
                                                <a href="/admin/costprojecttechcheck">
                                                    <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i>
                                                    </div>
                                                    <div class="mail-contnet"><h5>您有技术审核业务，点击前往</h5></div>
                                                </a>
                                            @elseif($value == 5)
                                                <a href="/admin/costprojectknotcheck">
                                                    <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i>
                                                    </div>
                                                    <div class="mail-contnet"><h5>您有结项审核业务，点击前往</h5></div>
                                                </a>
                                            @else
                                            @endif
                                        @endforeach
                                        @foreach(Auth::guard('admin')->user()->sonproject_info as $value)
                                            @if($value == 1)
                                                <a href="/admin/costsonprojectcheck">
                                                    <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i>
                                                    </div>
                                                    <div class="mail-contnet"><h5>您有项目初审业务，点击前往</h5></div>
                                                </a>
                                            @elseif($value == 2)
                                                <a href="/admin/costsonprojectprofessioncheck">
                                                    <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i>
                                                    </div>
                                                    <div class="mail-contnet"><h5>您有专项审核业务，点击前往</h5></div>
                                                </a>
                                            @else
                                            @endif
                                        @endforeach
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="@if(Auth::guard('admin')->user()->avatar){{ Auth::guard('admin')->user()->avatar }}@else{{ asset('admin/avatars/avatar.png') }}@endif"
                                 alt="user" class="profile-pic"/></a>
                        <div class="dropdown-menu dropdown-menu-right scale-up">
                            <ul class="dropdown-user">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-img">
                                            <input type="file" class="dropify" id="admin-avatar"
                                                   data-show-remove="false" data-height="70" data-max-file-size="1M"
                                                   data-allowed-file-extensions="jpg png"
                                                   data-default-file="@if(Auth::guard('admin')->user()->avatar){{ Auth::guard('admin')->user()->avatar }}@else{{ asset('admin/avatars/avatar.png') }}@endif"/>
                                        </div>
                                        <div class="u-text">
                                            <h4>{{ Auth::guard('admin')->user()->name }}</h4>
                                            <p class="text-muted">
                                                @if(Auth::guard('admin')->user()->roles->first())
                                                    {{ Auth::guard('admin')->user()->roles->first()->display_name }}
                                                @else
                                                    无角色
                                                @endif
                                            </p>
                                            <button id="save-admin-avatar" class="btn btn-rounded btn-danger btn-sm">
                                                上传头像
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ url('admin/myinfo') }}"><i class="ti-user"></i>&nbsp&nbsp我的信息</a></li>
                                <li role="separator" class="divider"></li>
                                <li id="change-password"><a href="#"><i class="ti-settings"></i>&nbsp&nbsp修改密码</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                                class="fa fa-power-off"></i>&nbsp&nbsp退出</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="left-sidebar">
        <div class="scroll-sidebar">
            <div class="user-profile"
                 style="background: url({{ asset('admin/assets/images/background/user-info.jpg') }}) no-repeat;">
                <div class="profile-img"><img
                            src="@if(Auth::guard('admin')->user()->avatar){{ Auth::guard('admin')->user()->avatar }}@else{{ asset('admin/avatars/avatar.png') }}@endif"
                            alt="user"/>
                </div>
                <div class="profile-text"><a href="javascript:void(0)" role="button">
                        @if(Auth::guard('admin')->user()->admininfo)
                            {{ Auth::guard('admin')->user()->admininfo->name }}，欢迎您！
                        @endif
                    </a>
                </div>
            </div>
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li>
                        <a class="waves-effect waves-dark" href="{{ url('admin/index') }}" aria-expanded="false"><i
                                    class="mdi mdi-gauge"></i><span class="hide-menu">首页 </span></a>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="{{ url('admin/contractmanage') }}"
                           aria-expanded="false"><i
                                    class="mdi mdi-store"></i><span class="hide-menu">项目管理</span></a>
                        <ul aria-expanded="false" class="collapse">
                            @permission('manageshow')
                            <li><a href="{{ url('admin/contractmanage') }}">合同管理</a></li>
                            <li><a href="{{ url('admin/projectunitmanage') }}">项目单位管理</a></li>
                            @endpermission
                            <li><a class="has-arrow" href="#" aria-expanded="false">造价项目管理</a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="{{ url('admin/costprojectinfo') }}">项目详情</a></li>
                                    @permission('projectallot')
                                    <li><a href="{{ url('admin/costprojectmanage') }}">项目分配</a></li>
                                    @endpermission
                                    @permission('projectfirstcheck')
                                    <li><a href="{{ url('admin/costsonprojectcheck') }}">项目初审</a></li>
                                    @endpermission
                                    <li><a href="{{ url('admin/costsonprojectprofessioncheck') }}">专项审核</a></li>
                                    <li><a href="{{ url('admin/costprojectcheck') }}">项目审核</a></li>
                                    @permission('projecttechcheck')
                                    <li><a href="{{ url('admin/costprojecttechcheck') }}">技术审核</a></li>
                                    @endpermission
                                    @permission('projectfirstcheck')
                                    <li><a href="{{ url('admin/costprojectknotcheck') }}">结项审核</a></li>
                                    @endpermission
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="{{ url('admin/myextract') }}"
                           aria-expanded="false"><i
                                    class="mdi mdi-coin"></i><span class="hide-menu">财务管理</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ url('admin/myextract') }}">我的提成</a></li>
                            @permission('financemanage')
                            <li><a href="{{ url('admin/financemanage') }}">财务管理</a></li>
                            <li><a href="{{ url('admin/extractstatistics') }}">提成统计</a></li>
                            @endpermission
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="{{ url('admin/ddd') }}"
                           aria-expanded="false"><i
                                    class="mdi mdi-account-edit"></i><span class="hide-menu">人员管理</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ url('admin/myinfo') }}">我的信息</a></li>
                            @permission('adminmanage')
                            <li><a href="{{ url('admin/adminmanagelist') }}">人员列表</a></li>
                            @endpermission
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="{{ url('admin/mysign') }}"
                           aria-expanded="false"><i
                                    class="mdi mdi-alarm"></i><span class="hide-menu">考勤管理</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ url('admin/mysign') }}">我的考勤</a></li>
                            @permission('signmanage')
                            <li><a href="{{ url('admin/signapplylist') }}">补签审核</a></li>
                            <li><a href="{{ url('admin/leaveapplylist') }}">请假审核</a></li>
                            <li><a href="{{ url('admin/signandleavestatistics') }}">考勤统计</a></li>
                            <li><a href="{{ url('admin/signandleavesummary') }}">考勤汇总</a></li>
                            <li><a href="{{ url('admin/dateset') }}">考勤设置</a></li>
                            @endpermission
                        </ul>
                    </li>
                    @permission('systemset')
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="{{ url('admin/roleset') }}"
                           aria-expanded="false"><i
                                    class="mdi mdi-settings"></i><span class="hide-menu">系统设置</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ url('admin/roleset') }}">角色管理</a></li>

                        </ul>
                    </li>
                    @endpermission
                </ul>
            </nav>
        </div>
        <div class="sidebar-footer">
            <a href="javascript:void(0)" class="link" data-toggle="tooltip" id="admin-sign-in"
               data-original-title="签到"><i class="mdi mdi-account-check"></i>
            </a>
            <a href="javascript:void(0)" class="link" data-toggle="tooltip" id="admin-sign-out"
               data-original-title="签退"><i class="mdi mdi-account-remove"></i>
            </a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="link"
               data-toggle="tooltip" data-original-title="退出" data-placement="top"><i class="mdi mdi-power"></i>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </aside>
    <div class="page-wrapper">
        <div class="container-fluid">
            @yield('admin-title')
            @yield('admin-content')
            <div class="right-sidebar">
                <div class="rpanel-title"> 页面调色 <span><i class="ti-close right-side-toggle"></i></span>
                </div>
                <div class="slimscrollright">
                    <div class="r-panel-body">
                        <ul id="themecolors" class="m-t-20">
                            <li><b>顶部栏</b></li>
                            <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                            <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                            <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                            <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme working">4</a></li>
                            <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                            <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                            <li class="d-block m-t-30"><b>左+顶部栏</b></li>
                            <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a>
                            </li>
                            <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                            <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                            <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                            <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a>
                            </li>
                            <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer text-center">
            © 2018 dup
        </footer>
    </div>
</div>
<div class="modal fade show" id="changePasswordModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">修改密码</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>原始密码：</label>
                        <input type="password" class="form-control" value=""
                               id="old-password"></div>
                    <div class="form-group">
                        <label>新 密 码：</label>
                        <input type="password" class="form-control" value=""
                               id="new-password"></div>
                    <div class="form-group">
                        <label>确认密码：</label>
                        <input type="password" class="form-control" value=""
                               id="new-password-confirmation"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">关闭
                </button>
                <button type="button" id="changePassword"
                        class="btn btn-success">确定
                </button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('admin/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('admin/js/waves.js') }}"></script>
<script src="{{ asset('admin/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('admin/js/custom.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/toast-master/js/jquery.toast.js') }}"></script>
@yield('admin-js')
<script src="{{ asset('admin/assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<script>
    $('#admin-sign-in').click(function () {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'adminSignIn',
            type: 'POST',
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
                    if ($('#my-sign-calendar').length > 0) {
                        $('#my-sign-calendar').fullCalendar('refetchEvents');
                    }
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
    $('#admin-sign-out').click(function () {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'adminSignOut',
            type: 'POST',
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
                    if ($('#my-sign-calendar').length > 0) {
                        $('#my-sign-calendar').fullCalendar('refetchEvents');
                    }
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
    $('#change-password').click(function () {
        $('#changePasswordModal').modal('show');
        $('#old-password').val('');
        $('#new-password').val('');
        $('#new-password-confirmation').val('');
    });
    $('#changePassword').click(function () {
        var old_password = $('#old-password').val();
        var new_password = $('#new-password').val();
        var new_password_confirmation = $('#new-password-confirmation').val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'changePassword',
            type: 'POST',
            data: {
                old_password: old_password,
                new_password: new_password,
                new_password_confirmation: new_password_confirmation
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
                    $('#changePasswordModal').modal('hide');
                    $.toast({
                        heading: '成功',
                        text: doc.data,
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
    $(function () {
        $('.dropify').dropify({
            messages: {
                'default': '',
                'replace': '',
                'remove': '',
                'error': 'error'
            },
            error: {
                'fileSize': 'error',
                'minWidth': 'error',
                'maxWidth': 'error',
                'minHeight': 'error',
                'maxHeight': 'error',
                'imageFormat': 'error'
            }
        });

        $('#save-admin-avatar').click(function () {
            var file = $('#admin-avatar').siblings('.dropify-preview')
                .children('.dropify-render').children('img')
                .attr('src');
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'uploadAvatar',
                type: 'POST',
                data: {
                    avatar: file
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
                        location.reload();
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
    });

</script>
</body>

</html>