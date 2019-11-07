<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{URL::asset('lib/layui-v2.5.4/css/layui.css')}}" media="all">
    <link rel="stylesheet" href="{{URL::asset('css/public.css')}}" media="all">
</head>
<body>
<div class="layuimini-container">
    <div class="layuimini-main">

        <blockquote class="layui-elem-quote layui-text">
            鉴于小伙伴的普遍反馈，先温馨提醒两个常见“问题”：1. <a href="/doc/base/faq.html#form" target="_blank">为什么select/checkbox/radio没显示？</a> 2. <a href="/doc/modules/form.html#render" target="_blank">动态添加的表单元素如何更新？</a>
        </blockquote>

        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>添加CMS菜单</legend>
        </fieldset>

        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">菜单名称</label>
                <div class="layui-input-block">
                    <input type="text" name="title" lay-verify="required" lay-reqtext="请输入菜单名称" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">上级菜单</label>
                <div class="layui-input-block">
                    <select name="parent" lay-filter="aihao">
                        <option value="">请选择</option>
                        @foreach($parent as $parent)
                        <option value="{{$parent['id']}}">{{$parent['title']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">菜单图标</label>
                <div class="layui-input-block">
                    <input type="text" name="icon" lay-verify="required" lay-reqtext="请输入菜单图标" placeholder="请输入菜单ICON" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">打开方式</label>
                <div class="layui-input-block">
                    <select name="target" lay-filter="aihao">
                        <option value=""></option>
                        <option value="_blank">_blank</option>
                        <option value="_self" selected="">_self</option>
                        <option value="_top">_top</option>
                        <option value="_parent">_parent</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">跳转路由</label>
                <div class="layui-input-block">
                    <input type="text" name="href" lay-verify="required" lay-reqtext="请输入跳转路由" placeholder="请输入菜单跳转路由" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-block">
                    <input type="checkbox" checked="" name="status" value="1" lay-skin="switch" lay-filter="switchTest" lay-text="有效|无效">
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="sub">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{URL::asset('lib/layui-v2.5.4/layui.js')}}" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    layui.use(['form', 'layedit'], function () {
        var form = layui.form
            , layer = layui.layer
            , layedit = layui.layedit;

        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');

        var $=layui.$;
        //监听提交
        form.on('submit(sub)', function (data) {
            // var params = da//ta;
            console.log(data);
            $.ajax({
                url:'/menu/create',
                type:'post',
                data:{params:data.field,_token:'{{ csrf_token() }}'},
                dataType:"json",
                success:function(data){
                    if(data.code == 200){
                        // layer.alert(JSON.stringify(data), {
                        //     title: '最终的提交信息'
                        // })
                        layer.msg('添加成功',{icon:5,time:1000});
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);//关闭当前页
                        window.parent.location.replace(location.href)//刷新父级页面
                    } else{
                        layer.alert("提交失败2！")
                    }
                },
                error:function(e){
                    layer.alert("提交失败1！")
                },
            });
            return false;
        });
    });
</script>

</body>
</html>