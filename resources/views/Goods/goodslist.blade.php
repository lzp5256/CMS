<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{URL::asset('layui/css/layui.css')}}" media="all">
    <link rel="stylesheet" href="{{URL::asset('style/admin.css')}}" media="all">
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item"></div>
        </div>

        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-useradmin" data-type="add">添加</button>
                <button class="layui-btn layuiadmin-btn-useradmin" data-type="shelves">上架</button>
                <button class="layui-btn layuiadmin-btn-useradmin" data-type="unshelves">下架</button>
                <!-- <button class="layui-btn layuiadmin-btn-useradmin" data-type="edit">编辑</button> -->
                
                <!-- <button class="layui-btn layuiadmin-btn-useradmin" data-type="batchdel">删除</button> -->
            </div>

            <table id="goods_list" lay-filter="goods_list"></table>
            <script type="text/html" id="imgTpl">
                <img style="display: inline-block; width: 50%; height: 100%;" src="">
            </script>
            <script type="text/html" id="table-useradmin-webuser">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
            </script>
        </div>
    </div>
</div>

<script src="{{URL::asset('layui/layui.js')}}"></script>
<script>
    layui.config({
        base: '/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table'], function(){
        var $ = layui.$,form = layui.form,table = layui.table;

        table.render({
            elem: '#goods_list',
            url: '/goods/list',
            method:'post',
            where: {_token:'{{csrf_token()}}'},
            cols: [[
                {type: "checkbox", width: 50, fixed: "left"},
                {field: 'id', title: 'ID'},
                {field: 'goods_name', title: '商品名称'},
                {field: 'goods_original_price', title: '商品原价'},
                {field: 'goods_price',  title: '商品单价'},
                {field: 'goods_vip_price',  title: '会员价格'},
                {field: 'goods_stock',  title: '商品库存'},
                {field: 'goods_sold',  title: '已售数量'},
                {field: 'redeem_str',  title: '积分兑换'},
                {field: 'advance_sale_str', title: '预售状态'},
                {field: 'status_str', title: '商品状态'},
                {field: 'reveal_str', title: '上架状态'},
                {field: 'create_time',  title: '创建时间'},
                {field: 'update_time',  title: '更新时间'},
            ]],
            limits: [10, 15, 20, 25, 50, 100],
            limit: 10,
            page: true
        });

        //事件
        var active = {
            batchdel: function(){
                var checkStatus = table.checkStatus('goods_list')
                    ,checkData = checkStatus.data; //得到选中的数据

                if(checkData.length === 0){
                    return layer.msg('请选择数据');
                }

                layer.prompt({
                    formType: 1
                    ,title: '敏感操作，请验证口令'
                }, function(value, index){
                    layer.close(index);
                    layer.confirm('确定删除吗？', function(index) {
                        $.ajax({
                            url:'/menu/del',
                            type:'post',
                            data:{params:checkData,_token:'{{ csrf_token() }}'},
                            dataType:"json",
                            success:function(data){
                                if(data.code == 200){
                                    layer.msg('删除成功',{icon:1,time:2000},function () {
                                        table.reload('goods_list');
                                    });
                                } else{
                                    layer.msg('删除失败',{icon:2,time:2000});
                                }
                            },
                            error:function(e){
                                layer.msg('删除失败',{icon:2,time:2000});
                            },
                        });
                        return false;
                    });
                });
            }
            // 新增
            ,add: function(){
                layer.open({
                    type: 2
                    ,title: '添加商品'
                    ,content: '/goods/goods_create'
                    ,maxmin: true
                    ,area: ['800px', '600px']
                });
            }
            // 编辑
            ,edit:function(){
                var checkStatus = table.checkStatus('goods_list')
                    ,checkData = checkStatus.data; //得到选中的数据

                if(checkData.length === 0){
                    return layer.msg('请选择数据');
                }
                id = checkData[0].id;
                console.log(id);
                layer.open({
                    type: 2
                    ,title: '编辑商品'
                    ,content: '/goods/goods_edit_view/id/'+ id
                    ,maxmin: true
                    ,area: ['800px', '600px']
                });
            }
            // 下架
            ,unshelves:function(){
                var checkStatus = table.checkStatus('goods_list')
                    ,checkData = checkStatus.data; //得到选中的数据

                if(checkData.length === 0){
                    return layer.msg('请选择数据');
                }

                id = checkData[0].id;
                layer.confirm('确定下架吗？', function(index) {
                    $.ajax({
                        url:'/goods/goods_unshelves',
                        type:'post',
                        data:{id:id,_token:'{{ csrf_token() }}'},
                        dataType:"json",
                        success:function(data){
                            if(data.code == 200){
                                layer.msg('下架成功[' + id + ']',{icon:1,time:2000},function () {
                                    table.reload('goods_list');
                                });
                            } else{
                                layer.msg('下架失败',{icon:2,time:2000});
                            }
                        },
                        error:function(e){
                            layer.msg('下架失败',{icon:2,time:2000});
                        },
                    });
                    return false;
                });
            }
            // 上架
            ,shelves:function(){
                var checkStatus = table.checkStatus('goods_list')
                    ,checkData = checkStatus.data; //得到选中的数据

                if(checkData.length === 0){
                    return layer.msg('请选择数据');
                }

                id = checkData[0].id;
                layer.confirm('确定上架吗？', function(index) {
                    $.ajax({
                        url:'/goods/goods_unshelves',
                        type:'post',
                        data:{id:id,_token:'{{ csrf_token() }}'},
                        dataType:"json",
                        success:function(data){
                            if(data.code == 200){
                                layer.msg('下架成功[' + id + ']',{icon:1,time:2000},function () {
                                    table.reload('goods_list');
                                });
                            } else{
                                layer.msg('下架失败',{icon:2,time:2000});
                            }
                        },
                        error:function(e){
                            layer.msg('下架失败',{icon:2,time:2000});
                        },
                    });
                    return false;
                });
            }
        };

        $('.layui-btn.layuiadmin-btn-useradmin').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>
