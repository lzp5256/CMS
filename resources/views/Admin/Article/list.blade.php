@extends('Admin.Layout.layout')

@section('content')

@endsection
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <input type="button" class="btn btn-primary radius" onclick="detail_view();" value="自定义按钮"/>
                <input type="button" class="btn btn-primary radius" onclick="offMoney()" value="自定义按钮"/>
            </div>
        </div>

        <div class="row">

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> 用户列表</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>用户名</th>
                                    <th>标签</th>
                                    <th>状态</th>
                                    <th>创建时间</th>
                                    <th>更新时间</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Row-->

    </div>
    <!-- End container-fluid-->

</div><!--End content-wrapper-->

</div><!--End wrapper-->

<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $().ready(function() {
        var table = $('#example').DataTable( {
            buttons: ['excel', 'pdf', 'print' ],
            lengthChange: false,
            paging:true,
            serverSide:true,
            iDisplayLength:10,
            "ajax": {
                "url": "/user/UserList",
                "type": 'post',
                "dataSrc":
                    function (res) {
                        console.log(res.data)
                        return res.data;
                    }
            },
            //使用对象数组，一定要配置columns，告诉 DataTables 每列对应的属性
            //data 这里是固定不变的，name，position，salary，office 为你数据里对应的属性
            columns: [
                {data: 'id'},
                { data: 'name' },
                { data: 'label' },
                { data: 'status' },
                { data: 'created_at' },
                { data: 'updated_at' },
            ],
            "language":{
                "sProcessing":"加载中...",
                "sLengthMenu":"_MENU_",
                "sZeroRecords":"没有匹配的结果",
                "sInfo": "显示 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                "sInfoEmpty": "显示 0 至 0 项结果，共 0 项",
                "sInfoFiltered": "(_MAX_条)",
                "sInfoPostFix": "",
                "sSearch": "搜索:",
                "sUrl": "",
                "sEmptyTable": "表中数据为空",
                "sLoadingRecords": "载入中...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "首页",
                    "sPrevious": "上一页",
                    "sNext": "下一页",
                    "sLast": "末页"
                }
            }
        });
        table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );
    });
</script>

