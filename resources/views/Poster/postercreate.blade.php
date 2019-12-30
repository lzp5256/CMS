<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{URL::asset('layui/css/layui.css')}}" media="all">
</head>
<body>

<div class="layui-form" lay-filter="goods_type_form" id="goods_type_form" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <label class="layui-form-label">海报名称</label>
        <div class="layui-input-block">
            <input type="text" name="poster_name" lay-verify="required" lay-reqtext="请输入海报名称" placeholder="请输入海报名称" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">链接地址</label>
        <div class="layui-input-block">
            <input type="text" name="poster_src" lay-verify="required" lay-reqtext="请输入海报链接地址" placeholder="请输入海报链接地址" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">海报图片</label>
        <div class="layui-input-block">
            <div class="layui-card-body">
                <button type="button" class="layui-btn layui-btn-danger" id="upload-describe">
                    <i class="layui-icon"></i>上传图片
                </button>
                <div class="layui-inline layui-word-aux" id="describe_str">这里以限制 60KB 为例</div>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">类型</label>
        <div class="layui-input-block">
            <select name="poster_type" lay-filter="redeem">
                <option value="-1">请选择</option>
                <option value="1">首页轮播</option>
                <option value="2">首页小海报</option>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">初始状态</label>
        <div class="layui-input-block">
            <select name="status" lay-filter="aihao">
                <option value="-1">请选择</option>
                <option value="1" selected>有效</option>
                <option value="0">无效</option>
            </select>
        </div>
    </div>



    <div class="layui-form-item" style="bottom:5px; text-align: center">
        <div class="layui-input-block">
            <input type="hidden" id="describe_img" name="upload_file">
            <button class="layui-btn" lay-submit lay-filter="sub">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</div>

<script src="{{URL::asset('layui/layui.js')}}" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    layui.use(['form', 'layedit','upload'], function () {
        var form = layui.form
            , layer = layui.layer
            , layedit = layui.layedit
            , upload = layui.upload;

        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');

        var $=layui.$;

        // 输入框自定义验证
        form.verify({
            money:function (val,item) {
                if(!/^\d+(\.\d{0,2})?$/.test(val)){
                    return '请输入正确的价格';
                }
            }
        });

        //监听提交
        form.on('submit(sub)', function (data) {
            console.log(data);
            $.ajax({
                url:'/poster/poster_create',
                type:'post',
                data:{params:data.field,_token:'{{ csrf_token() }}'},
                dataType:"json",
                success:function(data){
                    if(data.code == 200){
                        layer.msg('添加成功',{icon:1,time:2000},function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);//关闭当前页
                            parent.layui.table.reload('goods_type_list');//重载父页表格，参数为表格ID
                        });
                    } else{
                        layer.alert(data.msg,{icon:2,time: 2000});
                    }
                },
                error:function(e){
                    layer.alert("提交失败！")
                },
            });
            return false;
        });

        //设定文件大小限制
        upload.render({
            elem: '#upload-describe'
            ,url: '/common/upload'
            ,data:{type:2,_token:'{{ csrf_token() }}'}
            ,size: 1024 //限制文件大小，单位 KB
            ,done: function(res){
                layer.alert('上传成功!');
                $('#describe_str').text(res.data.key);
                $('#describe_img').val(res.data.key);
                // console.log(res)
            }
            ,error:function (err) {
                layer.alert('上传失败!,异常信息为:',err);
            }
        });
    });
</script>

</body>
</html>