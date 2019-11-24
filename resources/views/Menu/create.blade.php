

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{URL::asset('layui/css/layui.css')}}" media="all">
</head>
<body>

<div class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin" style="padding: 20px 0 0 0;">
    <div class="layui-form-item">
        <label class="layui-form-label">菜单名称</label>
        <div class="layui-input-inline">
            <input type="text" name="title" lay-verify="required" lay-reqtext="请输入菜单名称" placeholder="请输入菜单名称" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">菜单排序</label>
        <div class="layui-input-inline">
            <input type="text" name="sort" lay-verify="required" lay-reqtext="请输入菜单名称" placeholder="0为不排序,值越大越靠后" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">上级菜单</label>
        <div class="layui-input-inline">
            <select name="parent" lay-filter="aihao">
                <option value="">请选择</option>
                <option value="0">一级分类</option>
                @foreach($parent as $parent)
                    <option value="{{$parent['id']}}">{{$parent['title']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">菜单图标</label>
        <div class="layui-input-inline">
            <input type="text" name="icon" lay-verify="required" lay-reqtext="请输入菜单图标" placeholder="请输入菜单ICON(默认为fa)" value="fa" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">打开方式</label>
        <div class="layui-input-inline">
            <select name="target" lay-filter="aihao">
                <option value="_self" selected="">_self</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">跳转路由</label>
        <div class="layui-input-inline">
            <input type="text" name="href" lay-verify="required" lay-reqtext="请输入跳转路由" placeholder="请输入菜单跳转路由" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-inline">
            <input type="checkbox" checked="" name="status" value="1" lay-skin="switch" lay-filter="switchTest" lay-text="有效|无效">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="sub">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</div>

<script src="{{URL::asset('layui/layui.js')}}"></script>
<script>
    layui.config({
        base: '/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form', 'upload','table'], function(){
        var $ = layui.$
            ,form = layui.form
            ,upload = layui.upload
            ,table = layui.table;

        //监听提交
        form.on('submit(sub)', function (data) {
            $.ajax({
                url:'/menu/create',
                type:'post',
                data:{params:data.field,_token:'{{ csrf_token() }}'},
                dataType:"json",
                success:function(data){
                    if(data.code == 200){
                        layer.msg('添加成功',{icon:1,time:2000},function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);//关闭当前页
                            parent.layui.table.reload('menu_list');//重载父页表格，参数为表格ID
                        });
                    } else{
                        layer.msg(data.msg,{icon:2,time:2000});
                    }
                },
                error:function(e){
                    layer.msg('添加失败',{icon:2,time:2000});
                },
            });
            return false;
        });

        upload.render({
            elem: '#layuiadmin-upload-useradmin'
            ,url: layui.setter.base + 'json/upload/demo.js'
            ,accept: 'images'
            ,method: 'get'
            ,acceptMime: 'image/*'
            ,done: function(res){
                $(this.item).prev("div").children("input").val(res.data.src)
            }
        });
    })
</script>
</body>
</html>