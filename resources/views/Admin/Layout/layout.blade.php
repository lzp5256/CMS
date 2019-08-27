<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content=""/>
    <title>Muyao - Admin</title>
    <!--favicon-->
    <link rel="icon" href="{{URL::asset('images/favicon.ico')}}" type="image/x-icon"/>
    <!-- simplebar CSS-->
    <link href="{{URL::asset('plugins/simplebar/css/simplebar.css')}}" rel="stylesheet"/>
    <!-- Bootstrap core CSS-->
    <link href="{{URL::asset('css/bootstrap.min.css')}}" rel="stylesheet"/>
    <!-- animate CSS-->
    <link href="{{URL::asset('css/animate.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Icons CSS-->
    <link href="{{URL::asset('css/icons.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Sidebar CSS-->
    <link href="{{URL::asset('css/sidebar-menu.css')}}" rel="stylesheet"/>
    <!-- Custom Style-->
    <link href="{{URL::asset('css/app-style.css')}}" rel="stylesheet"/>

    <!--Data Tables -->
    <link href="{{URL::asset('plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">

</head>

<body>

<!-- start loader -->
<div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
<!-- end loader -->

<!-- Start wrapper-->
<div id="wrapper">

    <!--Start sidebar-wrapper-->
    <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
        <div class="brand-logo">
            <a href="index.html">
                <img src="{{URL::asset('images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
                <h5 class="logo-text">MuYao-ADMIN</h5>
            </a>
        </div>

        <div class="user-details">
            <div class="side-avatar mb-3"><img class="side-user-img" src="{{URL::asset('images/avatars/avatar-5.png')}}" alt="user avatar"></div>
            <div class="text-center">
                <h6 class="mb-0">上海沐曜信息科技有限公司</h6>
            </div>
        </div>

        <ul class="sidebar-menu do-nicescrol">
            <li class="sidebar-header">菜单栏</li>

            <li>
                <a href="javaScript:void();" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>用户管理</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="/user/UserList"><i class="zmdi zmdi-long-arrow-right"></i>用户列表</a></li>
                </ul>
            </li>
            <li>
                <a href="javaScript:void();" class="waves-effect">
                    <i class="zmdi zmdi-card-travel"></i>
                    <span>内容管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="components-range-slider.html"><i class="zmdi zmdi-long-arrow-right"></i> 文章列表</a></li>
                </ul>
            </li>
            <li>
                <a href="javaScript:void();" class="waves-effect">
                    <i class="zmdi zmdi-chart"></i> <span>系统配置</span>
                    <i class="fa fa-angle-left float-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li><a href="charts-chartjs.html"><i class="zmdi zmdi-long-arrow-right"></i> Chart JS</a></li>
                    <li><a href="charts-morris.html"><i class="zmdi zmdi-long-arrow-right"></i> Morris Charts</a></li>
                    <li><a href="charts-sparkline.html"><i class="zmdi zmdi-long-arrow-right"></i> Sparkline Charts</a></li>
                    <li><a href="charts-peity.html"><i class="zmdi zmdi-long-arrow-right"></i> Peity Charts</a></li>
                    <li><a href="charts-other.html"><i class="zmdi zmdi-long-arrow-right"></i> Other Charts</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!--End sidebar-wrapper-->

    <!--Start topbar header-->
    <header class="topbar-nav">
        <nav class="navbar navbar-expand fixed-top">

            <ul class="navbar-nav mr-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link toggle-menu" href="javascript:void();">
                        <i class="icon-menu menu-icon"></i>
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav align-items-center right-nav-link">

                <li class="nav-item dropdown-lg">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                        <i class="fa fa-envelope-open-o"></i><span class="badge badge-danger badge-up">0</span></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                You have 22 new messages
                                <span class="badge badge-danger">22</span>
                            </li>
                            <li class="list-group-item">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar"><img class="align-self-start mr-3" src="" alt="user avatar"></div>
                                        <div class="media-body">
                                            <h6 class="mt-0 msg-title">Jhon Deo</h6>
                                            <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                            <small>Today, 4:10 PM</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar"><img class="align-self-start mr-3" src="" alt="user avatar"></div>
                                        <div class="media-body">
                                            <h6 class="mt-0 msg-title">Sara Jen</h6>
                                            <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                            <small>Yesterday, 8:30 AM</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar"><img class="align-self-start mr-3" src="" alt="user avatar"></div>
                                        <div class="media-body">
                                            <h6 class="mt-0 msg-title">Dannish Josh</h6>
                                            <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                            <small>5/11/2018, 2:50 PM</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar"><img class="align-self-start mr-3" src="" alt="user avatar"></div>
                                        <div class="media-body">
                                            <h6 class="mt-0 msg-title">Katrina Mccoy</h6>
                                            <p class="msg-info">Lorem ipsum dolor sit amet.</p>
                                            <small>1/11/2018, 2:50 PM</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="list-group-item text-center"><a href="javaScript:void();">See All Messages</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item dropdown-lg">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                        <i class="fa fa-bell-o"></i><span class="badge badge-info badge-up">0</span></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                You have 14 Notifications
                                <span class="badge badge-info">0</span>
                            </li>
                            <li class="list-group-item">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <i class="zmdi zmdi-accounts fa-2x mr-3 text-info"></i>
                                        <div class="media-body">
                                            <h6 class="mt-0 msg-title">New Registered Users</h6>
                                            <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <i class="zmdi zmdi-coffee fa-2x mr-3 text-warning"></i>
                                        <div class="media-body">
                                            <h6 class="mt-0 msg-title">New Received Orders</h6>
                                            <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <i class="zmdi zmdi-notifications-active fa-2x mr-3 text-danger"></i>
                                        <div class="media-body">
                                            <h6 class="mt-0 msg-title">New Updates</h6>
                                            <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="list-group-item text-center"><a href="javaScript:void();">See All Notifications</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item language">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();"><i class="fa fa-flag"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item"> <i class="flag-icon flag-icon-gb mr-2"></i> English</li>
                        <li class="dropdown-item"> <i class="flag-icon flag-icon-fr mr-2"></i> French</li>
                        <li class="dropdown-item"> <i class="flag-icon flag-icon-cn mr-2"></i> Chinese</li>
                        <li class="dropdown-item"> <i class="flag-icon flag-icon-de mr-2"></i> German</li>
                    </ul>
                </li>
            <!--
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                        <span class="user-profile"><img src="{{URL::asset('images/avatars/avatar-13.png')}}" class="img-circle" alt="user avatar"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item user-details">
                            <a href="javaScript:void();">
                                <div class="media">
                                    <div class="avatar"><img class="align-self-start mr-3" src="{{URL::asset('images/avatars/avatar-13.png')}}" alt="user avatar"></div>
                                    <div class="media-body">
                                        <h6 class="mt-2 user-title">Sarajhon Mccoy</h6>
                                        <p class="user-subtitle">mccoy@example.com</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><i class="icon-envelope mr-2"></i> Inbox</li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Account</li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><i class="icon-power mr-2"></i> Logout</li>
                    </ul>
                </li>
                -->
            </ul>
        </nav>
    </header>
    <!--End topbar header-->

    <div class="clearfix"></div>
@yield('content')

<!--Start footer-->
    <footer class="footer">
        <div class="container">
            <div class="text-center">
                Copyright © 2019 @上海沐曜信息科技有限公司
            </div>
        </div>
    </footer>
    <!--End footer-->

</div><!--End wrapper-->


<!-- Bootstrap core JavaScript-->
<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script src="{{URL::asset('js/popper.min.js')}}"></script>
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>

<!-- simplebar js -->
<script src="{{URL::asset('plugins/simplebar/js/simplebar.js')}}"></script>
<!-- sidebar-menu js -->
<script src="{{URL::asset('js/sidebar-menu.js')}}"></script>

<!-- Custom scripts -->
<script src="{{URL::asset('js/app-script.js')}}"></script>

<!-- Chart js -->
<script src="{{URL::asset('plugins/Chart.js/Chart.min.js')}}"></script>
<script src="{{URL::asset('plugins/Chart.js/Chart.extension.js')}}"></script>
<!-- Sparkline JS -->
<script src="{{URL::asset('plugins/sparkline-charts/jquery.sparkline.min.js')}}"></script>


<script src=" {{URL::asset('plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"> </script>
<!-- Knob Chart -->
<script src="{{URL::asset('plugins/jquery-knob/excanvas.js')}}"></script>
<script src="{{URL::asset('plugins/jquery-knob/jquery.knob.js')}}"></script>
<script>
    $(function() {
        $(".knob").knob();
    });
</script>
<!--Peity Chart -->
<script src="{{URL::asset('plugins/peity/jquery.peity.min.js')}}"></script>

<!--Data Tables js-->
<script src="{{URL::asset('plugins/bootstrap-datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('plugins/bootstrap-datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('plugins/bootstrap-datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('plugins/bootstrap-datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('plugins/bootstrap-datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('plugins/bootstrap-datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('plugins/bootstrap-datatable/js/buttons.colVis.min.js')}}"></script>


</body>
</html>