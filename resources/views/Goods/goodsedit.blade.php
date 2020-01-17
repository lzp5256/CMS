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
        <label class="layui-form-label">商品名称</label>
        <div class="layui-input-block">
            <input type="text" name="goods_name" value="{{$goods_info['goods_name']}}" lay-verify="required" lay-reqtext="请输入商品名称" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">商品原价</label>
        <div class="layui-input-block">
            <input type="text" name="goods_original_price" value="{{$goods_info['goods_original_price']}}" lay-verify="required|money|number" lay-reqtext="请输入商品名称" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">商品单价</label>
        <div class="layui-input-block">
            <input type="text" name="goods_price" value="{{$goods_info['goods_original_price']}}" lay-verify="required|money|number" lay-reqtext="请输入商品单价" placeholder="请输入商品单价" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">会员单价</label>
        <div class="layui-input-block">
            <input type="text" name="goods_vip_price" value="{{$goods_info['goods_original_price']}}" lay-verify="required|money|number" lay-reqtext="请输入会员单价" placeholder="请输入会员单价" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">商品库存</label>
        <div class="layui-input-block">
            <input type="text" name="goods_stock" value="{{$goods_info['goods_original_price']}}" lay-verify="required|number" lay-reqtext="请输入商品库存" placeholder="请输入商品库存" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">积分兑换</label>
        <div class="layui-input-block">
            <select name="goods_redeem" lay-filter="redeem">
                <option value="-1">请选择</option>
                <option value="1" @if($goods_info['goods_redeem'] == 1) selected @endif >开启</option>
                <option value="0" @if($goods_info['goods_redeem'] == 0) selected @endif >关闭</option>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">初始状态</label>
        <div class="layui-input-block">
            <select name="status" lay-filter="aihao">
                <option value="-1">请选择</option>
                <option value="1" @if($goods_info['status'] == 1) selected @endif>有效</option>
                <option value="0" @if($goods_info['status'] == 0) selected @endif>无效</option>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">商品首图</label>
        <div class="layui-input-block">
            <div class="layui-card-body">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-normal" id="test-upload-testList">选择文件</button>
                    <button type="button" class="layui-btn" id="upload-Action" value="1" name="goods_master_graph">开始上传</button>
                    <div class="layui-upload-list">
                        <table class="layui-table">
                            <thead>
                            <tr><th>文件名</th>
                                <th>大小</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr></thead>
                            <tbody id="test-upload-demoList"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-upload-list">
            @foreach ($goods_info['master_pic'] as $k => $v)
                <img class="layui-upload-img" id="demo1" src="http://img.muyaocn.com/{{$v}}">
                <p id="demoText"></p>
            @endforeach
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">商品描述</label>
        <div class="layui-input-block">
            <div class="layui-card-body">
                <textarea name="goods_discrebe" id="goods_discribe" style="display: none;">{{$goods_info['goods_describe']}}</textarea>
            </div>
        </div>
    </div>

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">类型描述</label>
        <div class="layui-input-block">
            <textarea name="describe" placeholder="请输入内容" class="layui-textarea">{{$goods_info['goods_describe']}}</textarea>
        </div>
    </div>

    <div class="layui-form-item" style="bottom:5px; text-align: center">
        <div class="layui-input-block">
            <input type="hidden" id="master_img" name="upload_master_file">
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

        layedit.set({
            uploadImage: {
                url: '/common/e_upload' //接口url
                ,type: '' //默认post
                ,data: {_token: '{{ csrf_token() }}'}
            }
        });
        //创建一个编辑器
        var index = layedit.build('goods_discribe');
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
            var edit_data = layedit.getContent(index);
            data.field.describe_content = edit_data;
            console.log(data);
            $.ajax({
                url:'/goods/goods_create',
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

        //多文件列表示例
        var demoListView = $('#test-upload-demoList')
            ,uploadListIns = upload.render({
            elem: '#test-upload-testList'
            ,url: '/common/upload'
            ,method:'POST'
            ,data: {type:$('#upload-Action').val(),_token: '{{ csrf_token() }}'}
            ,accept: 'file'
            ,multiple: true
            ,auto: false
            ,bindAction: '#upload-Action'
            ,choose: function(obj){
                var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                //读取本地文件
                obj.preview(function(index, file, result){
                    var tr = $(['<tr id="upload-'+ index +'">'
                        ,'<td>'+ file.name +'</td>'
                        ,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
                        ,'<td>等待上传</td>'
                        ,'<td>'
                        ,'<button class="layui-btn layui-btn-mini upload-reload layui-hide">重传</button>'
                        ,'<button class="layui-btn layui-btn-mini layui-btn-danger upload-delete">删除</button>'
                        ,'</td>'
                        ,'</tr>'].join(''));

                    //单个重传
                    tr.find('.upload-reload').on('click', function(){
                        obj.upload(index, file);
                    });

                    //删除
                    tr.find('.upload-delete').on('click', function(){
                        delete files[index]; //删除对应的文件
                        tr.remove();
                        uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                    });

                    demoListView.append(tr);
                });
            }
            ,done: function(res, index, upload){
                if(res.code == 200){ //上传成功
                    var tr = demoListView.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(3).html(''); //清空操作
                    $('#master_img').val($("#master_img").val() + ',' + res.data.key);
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                this.error(index, upload);
            }
            ,error: function(index, upload){
                var tr = demoListView.find('tr#upload-'+ index)
                    ,tds = tr.children();
                tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(3).find('.upload-reload').removeClass('layui-hide'); //显示重传
            }
        });

        //设定文件大小限制
        upload.render({
            elem: '#upload-describe'
            ,url: '/common/upload'
            ,data:{type:2,_token:'{{ csrf_token() }}'}
            ,size: 1024 //限制文件大小，单位 KB
            ,done: function(res){
                $('#describe_str').text(res.data.key);
                $('#describe_img').val(res.data.key);
                // console.log(res)
            }
        });
    });
</script>

</body>
</html>