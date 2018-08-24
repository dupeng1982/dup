<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="测试网站">
    <meta name="author" content="dupeng">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/assets/images/favicon.png') }}">
    <title>{{ config('app.name', '测试应用') }}</title>
    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet"/>
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
                <a class="navbar-brand" href="index.html">
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
                    <li class="nav-item dropdown mega-dropdown"><a
                                class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    class="mdi mdi-view-grid"></i></a>
                        <div class="dropdown-menu scale-up-left">
                            <ul class="mega-dropdown-menu row">
                                <li class="col-lg-3 col-xlg-2 m-b-30">
                                    <h4 class="m-b-20">CAROUSEL</h4>
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">
                                            <div class="carousel-item active">
                                                <div class="container"><img class="d-block img-fluid"
                                                                            src="{{ asset('admin/assets/images/big/img1.jpg') }}"
                                                                            alt="First slide"></div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="container"><img class="d-block img-fluid"
                                                                            src="{{ asset('admin/assets/images/big/img2.jpg') }}"
                                                                            alt="Second slide"></div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="container"><img class="d-block img-fluid"
                                                                            src="{{ asset('admin/assets/images/big/img3.jpg') }}"
                                                                            alt="Third slide"></div>
                                            </div>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                           data-slide="prev"> <span class="carousel-control-prev-icon"
                                                                    aria-hidden="true"></span> <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                           data-slide="next"> <span class="carousel-control-next-icon"
                                                                    aria-hidden="true"></span> <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </li>
                                <li class="col-lg-3 m-b-30">
                                    <h4 class="m-b-20">ACCORDION</h4>
                                    <div id="accordion" class="nav-accordion" role="tablist"
                                         aria-multiselectable="true">
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingOne">
                                                <h5 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseOne" aria-expanded="true"
                                                       aria-controls="collapseOne">
                                                        Collapsible Group Item #1
                                                    </a>
                                                </h5></div>
                                            <div id="collapseOne" class="collapse show" role="tabpanel"
                                                 aria-labelledby="headingOne">
                                                <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod
                                                    high.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseTwo" aria-expanded="false"
                                                       aria-controls="collapseTwo">
                                                        Collapsible Group Item #2
                                                    </a>
                                                </h5></div>
                                            <div id="collapseTwo" class="collapse" role="tabpanel"
                                                 aria-labelledby="headingTwo">
                                                <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod
                                                    high life accusamus terry richardson ad squid.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingThree">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseThree" aria-expanded="false"
                                                       aria-controls="collapseThree">
                                                        Collapsible Group Item #3
                                                    </a>
                                                </h5></div>
                                            <div id="collapseThree" class="collapse" role="tabpanel"
                                                 aria-labelledby="headingThree">
                                                <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod
                                                    high life accusamus terry richardson ad squid.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="col-lg-3  m-b-30">
                                    <h4 class="m-b-20">CONTACT US</h4>
                                    <form>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exampleInputname1"
                                                   placeholder="Enter Name"></div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Enter email"></div>
                                        <div class="form-group">
                                            <textarea class="form-control" id="exampleTextarea" rows="3"
                                                      placeholder="Message"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </form>
                                </li>
                                <li class="col-lg-3 col-xlg-4 m-b-30">
                                    <h4 class="m-b-20">List style</h4>
                                    <ul class="list-style-none">
                                        <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> You
                                                can give link</a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Give
                                                link</a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i>
                                                Another Give link</a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Forth
                                                link</a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i>
                                                Another fifth link</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav my-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                    class="mdi mdi-message"></i>
                            <div class="notify"><span class="heartbit"></span> <span class="point"></span></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                            <ul>
                                <li>
                                    <div class="drop-title">Notifications</div>
                                </li>
                                <li>
                                    <div class="message-center">
                                        <a href="#">
                                            <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Luanch Admin</h5> <span
                                                        class="mail-desc">Just see the my new admin!</span> <span
                                                        class="time">9:30 AM</span></div>
                                        </a>
                                        <a href="#">
                                            <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span>
                                                <span class="time">9:10 AM</span></div>
                                        </a>
                                        <a href="#">
                                            <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span>
                                                <span class="time">9:08 AM</span></div>
                                        </a>
                                        <a href="#">
                                            <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Pavan kumar</h5> <span
                                                        class="mail-desc">Just see the my admin!</span> <span
                                                        class="time">9:02 AM</span></div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all
                                            notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                    class="mdi mdi-email"></i>
                            <div class="notify"><span class="heartbit"></span> <span class="point"></span></div>
                        </a>
                        <div class="dropdown-menu mailbox dropdown-menu-right scale-up" aria-labelledby="2">
                            <ul>
                                <li>
                                    <div class="drop-title">You have 4 new messages</div>
                                </li>
                                <li>
                                    <div class="message-center">
                                        <a href="#">
                                            <div class="user-img"><img
                                                        src="{{ asset('admin/assets/images/users/1.jpg') }}" alt="user"
                                                        class="img-circle"> <span
                                                        class="profile-status online pull-right"></span></div>
                                            <div class="mail-contnet">
                                                <h5>Pavan kumar</h5> <span
                                                        class="mail-desc">Just see the my admin!</span> <span
                                                        class="time">9:30 AM</span></div>
                                        </a>
                                        <a href="#">
                                            <div class="user-img"><img
                                                        src="{{ asset('admin/assets/images/users/2.jpg') }}" alt="user"
                                                        class="img-circle"> <span
                                                        class="profile-status busy pull-right"></span></div>
                                            <div class="mail-contnet">
                                                <h5>Sonu Nigam</h5> <span
                                                        class="mail-desc">I've sung a song! See you at</span> <span
                                                        class="time">9:10 AM</span></div>
                                        </a>
                                        <a href="#">
                                            <div class="user-img"><img
                                                        src="{{ asset('admin/assets/images/users/3.jpg') }}" alt="user"
                                                        class="img-circle"> <span
                                                        class="profile-status away pull-right"></span></div>
                                            <div class="mail-contnet">
                                                <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span
                                                        class="time">9:08 AM</span></div>
                                        </a>
                                        <a href="#">
                                            <div class="user-img"><img
                                                        src="{{ asset('admin/assets/images/users/4.jpg') }}" alt="user"
                                                        class="img-circle"> <span
                                                        class="profile-status offline pull-right"></span></div>
                                            <div class="mail-contnet">
                                                <h5>Pavan kumar</h5> <span
                                                        class="mail-desc">Just see the my admin!</span> <span
                                                        class="time">9:02 AM</span></div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all
                                            e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="{{ asset('admin/assets/images/users/1.jpg') }}" alt="user"
                                    class="profile-pic"/></a>
                        <div class="dropdown-menu dropdown-menu-right scale-up">
                            <ul class="dropdown-user">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-img"><img src="{{ asset('admin/assets/images/users/1.jpg') }}"
                                                                alt="user"></div>
                                        <div class="u-text">
                                            <h4>Steave Jobs</h4>
                                            <p class="text-muted">varun@gmail.com</p><a href="profile.html"
                                                                                        class="btn btn-rounded btn-danger btn-sm">View
                                                Profile</a></div>
                                    </div>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                                <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                                <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                    class="flag-icon flag-icon-us"></i></a>
                        <div class="dropdown-menu dropdown-menu-right scale-up"><a class="dropdown-item" href="#"><i
                                        class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i
                                        class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item"
                                                                                          href="#"><i
                                        class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i
                                        class="flag-icon flag-icon-de"></i> Dutch</a></div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="left-sidebar">
        <div class="scroll-sidebar">
            <div class="user-profile"
                 style="background: url({{ asset('admin/assets/images/background/user-info.jpg') }}) no-repeat;">
                <div class="profile-img"><img src="{{ asset('admin/assets/images/users/profile.png') }}" alt="user"/>
                </div>
                <div class="profile-text"><a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown"
                                             role="button" aria-haspopup="true" aria-expanded="true">Markarn Doe</a>
                    <div class="dropdown-menu animated flipInY">
                        <a href="#" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                        <a href="#" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>
                        <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                        <div class="dropdown-divider"></div>
                        <a href="login.html" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                    </div>
                </div>
            </div>
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li>
                        <a class="waves-effect waves-dark" href="{{ url('admin/index') }}" aria-expanded="false"><i
                                    class="mdi mdi-gauge"></i><span class="hide-menu">首页 </span></a>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="{{ url('admin/aaa') }}"
                           aria-expanded="false"><i
                                    class="mdi mdi-store"></i><span class="hide-menu">项目管理</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ url('admin/aaa') }}">合同管理</a></li>
                            <li><a href="{{ url('admin/bbb') }}">项目管理</a></li>
                            <li><a href="{{ url('admin/bbb') }}">单位管理</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="{{ url('admin/ccc') }}"
                           aria-expanded="false"><i
                                    class="mdi mdi-coin"></i><span class="hide-menu">财务管理</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ url('admin/ccc') }}">财务设置</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="{{ url('admin/mysign') }}"
                           aria-expanded="false"><i
                                    class="mdi mdi-alarm"></i><span class="hide-menu">考勤管理</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ url('admin/mysign') }}">我的考勤</a></li>
                            <li><a href="{{ url('admin/dateset') }}">考勤设置</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="{{ url('admin/roleset') }}"
                           aria-expanded="false"><i
                                    class="mdi mdi-settings"></i><span class="hide-menu">系统设置</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ url('admin/roleset') }}">角色管理</a></li>

                        </ul>
                    </li>
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
            © 2018 dup by agency.com
        </footer>
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
</script>
</body>

</html>