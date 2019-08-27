<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Xmino - Admin</title>
    <!--favicon-->
    <link rel="icon" href="{{URL::asset('images/favicon.ico')}}" type="image/x-icon">
    <!-- Bootstrap core CSS-->
    <link href="{{URL::asset('css/bootstrap.min.css')}}" rel="stylesheet"/>
    <!-- animate CSS-->
    <link href="{{URL::asset('css/animate.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Icons CSS-->
    <link href="{{URL::asset('css/icons.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Custom Style-->
    <link href="{{URL::asset('css/app-style.css')}}" rel="stylesheet"/>
    <!-- Sidebar CSS-->
    <link href="{{URL::asset('css/sidebar-menu.css')}}" rel="stylesheet"/>
    <!-- simplebar CSS-->
    <link href="{{URL::asset('plugins/simplebar/css/simplebar.css')}}" rel="stylesheet"/>

    <!-- notifications css -->
    <link rel="stylesheet" href="{{URL::asset('plugins/notifications/css/lobibox.min.css')}}"/>

</head>

<body>

<!-- start loader -->
<div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
<!-- end loader -->

<!-- Start wrapper-->
<div id="wrapper">

    <div class="card-authentication2 mx-auto my-5">
        <div class="card-group">
            <div class="card mb-0">
                <div class="bg-signin2"></div>
                <div class="card-img-overlay rounded-left my-5">
                    <h2 class="text-white">Lorem</h2>
                    <h1 class="text-white">Ipsum Dolor</h1>
                    <p class="card-text text-white pt-3">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                </div>
            </div>

            <div class="card mb-0 ">
                <div class="card-body">
                    <div class="card-content p-3">
                        <div class="text-center">
                            <img src="{{URL::asset('images/logo-icon.png')}}" alt="logo icon">
                        </div>
                        <div class="card-title text-uppercase text-center py-3">登 录</div>
                        <form id="loginForm">
                            <div class="form-group">
                                <div class="position-relative has-icon-left">
                                    <div class="position-relative has-icon-left">
                                        <label for="UserName" class="sr-only">用户名:</label>
                                        <input type="text" class="form-control" id="userName" name="userName" placeholder="请输入用户名">
                                        <div class="form-control-position">
                                            <i class="icon-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="position-relative has-icon-left">
                                    <label for="passWord" class="sr-only">密码:</label>
                                    <input type="password" class="form-control" id="passWord" name="passWord" placeholder="请输入密码">
                                    <div class="form-control-position">
                                        <i class="icon-lock"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mr-0 ml-0">
                                <div class="form-group col-6">
                                    <div class="icheck-material-primary">
                                        <input type="checkbox" id="user-checkbox" checked="" />
                                        <label for="user-checkbox">记住我</label>
                                    </div>
                                </div>
                                <div class="form-group col-6 text-right">
                                    <a href="authentication-reset-password2.html">忘记密码</a>
                                </div>
                            </div>
                            <button type="button" onclick="toLogin()" class="btn btn-primary btn-block waves-effect waves-light">登录</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->


</div><!--wrapper-->

</body>
</html>

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

<script src="{{URL::asset('plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>

<!--notification js -->
<script src="{{URL::asset('plugins/notifications/js/lobibox.min.js')}}"></script>
<script src="{{URL::asset('plugins/notifications/js/notifications.min.js')}}"></script>
<script src="{{URL::asset('plugins/notifications/js/notification-custom-script.js')}}"></script>

<!-- 检查参数 -->
<script>
    $().ready(function() {
        $("#loginForm").validate({
            rules: {
                userName: {
                    required: true,
                    minlength: 4,
                },
                passWord: {
                    required: true,
                    minlength: 5
                },
            },
            messages: {
                userName: {
                    required: "请输入用户名",
                    minlength: "用户名长度需大于4位"
                },
                passWord: {
                    required: "请输入正确的密码",
                    minlength: "密码长度必须至少为5个字符"
                },

            }
        });
    });
</script>

<script>
    function toLogin() {
        console.log('============start====================')
        var userName = $('#userName').val();
        var userPwd  = $('#passWord').val();
        $(function(){
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
            });
            $.ajax({
                url:"/user/login", //路由地址
                type:"POST",
                data:{"userName":userName,"userPwd":userPwd},
                success:function(res){
                    var obj = JSON.parse(res)
                    console.log(obj)
                    console.log(obj.code)
                    if(obj.code != 1){
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            icon: 'fa fa-times-circle',
                            position: 'center top',
                            showClass: 'lightSpeedIn',
                            hideClass: 'lightSpeedOut',
                            width: 600,
                            msg: obj.msg
                        });
                    }else{
                        Lobibox.notify('success', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'center top',
                            showClass: 'rollIn',
                            hideClass: 'rollOut',
                            icon: 'fa fa-check-circle',
                            width: 600,
                            msg: obj.msg
                        });
                        setTimeout(function(){
                            window.location.href="/home/index";
                        },2000)

                    }
                },
                error:function(){
                    console.log(res);
                }
            });
        })
        return false;
    }

</script>
