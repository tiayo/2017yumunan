@extends('manage.layouts.app')

@section('title', '结束订单')

@section('style')
    @parent
@endsection

@section('breadcrumb')
        <li navValue="nav_3"><a href="#">订单管理</a></li>
        <li navValue="nav_3_3"><a href="#">结束订单</a></li>
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
        <!--错误输出-->
        <div class="form-group">
            <div class="alert alert-danger fade in @if(!count($errors) > 0) hidden @endif" id="alert_error">
                <a href="#" class="close" data-dismiss="alert">×</a>
                <span>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </span>
            </div>
        </div>

		<section class="panel">
            <div class="panel-body">
                <form class="form-inline" id="search_form">
                    <div class="form-group">
                        <label class="sr-only" for="search"></label>
                        <input type="text" class="form-control" id="search" name="keyword"
                               value="{{ Request::get('keyword') }}" placeholder="输入订单号" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="salesman_search">搜索</button>
                </form>
            <header class="panel-heading">
                订单列表
            </header>
            	<table class="table table-striped table-hover">
		            <thead>
		                <tr>
		                    <th>ID</th>
		                    <th>用户</th>
		                    <th>客房</th>
		                    <th>房号</th>
		                    <th>天数</th>
                            <th>电话</th>
                            <th>价格</th>
                            <th>订单状态</th>
                            <th>更新时间</th>
                            <th>创建时间</th>
							<th>操作</th>
		                </tr>
		            </thead>

		            <tbody id="target">
                        @foreach($lists as $list)
                            <tr>
                                <td>{{ $list['id'] }}</td>
                                <td>{{ $list->user->name }}</td>
                                <td>{{ $list->commodity->name }}</td>
                                <td>{{ $list['room'] }}</td>
                                <td>{{ $list['day'] }}</td>
                                <td>{{ $list->user->phone }}</td>
                                <td>￥{{ $list['price'] }}</td>
                                <td style="color: red">
                                    {{ config('site.order_status')[$list['status']] }}
                                </td>
                                <td>{{ $list['updated_at'] }}</td>
                                <td>{{ $list['created_at'] }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button" id="btnGroupDrop1">
                                            更改状态 <span class="caret"></span>
                                        </button>
                                        <ul aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                                            @foreach(config('site.order_status') as $key => $order_status)
                                                <li>
                                                    <a href="{{ route('order_status', ['order_id' => $list['id'], 'status' => $key]) }}"
                                                       onClick="return confirm('“确定”将会执行一系列不可恢复的操作，请选择：?');">
                                                        {{ $order_status }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                        <button class="btn btn-info" type="button" onclick="location='{{ route('order_update', ['id' => $list['id'] ]) }}'">编辑</button>
                                        <button class="btn btn-danger" type="button" onclick="javascript:if(confirm('确实要删除吗?'))location='{{ route('order_destroy', ['id' => $list['id'] ]) }}'">删除</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
		        </table>

               {{ $lists->links() }}
            </div>
    	</section>
    </div>
</div>
@endsection

@section('script')
    @parent
    {{--转换搜索链接--}}
    <script type="text/javascript">
        $(document).ready(function () {

            $('#search_form').submit(function () {

                var keyword = $('#search').val();

                if (stripscript(keyword) == '') {
                    $('#search').val('');
                    return false;
                }

                window.location = '{{ route('order_search', ['keyword' => '']) }}/' + stripscript(keyword);

                return false;
            });

        });

        function stripscript(s)
        {
            var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]");
            var rs = "";
            for (var i = 0; i < s.length; i++) {
                rs = rs+s.substr(i, 1).replace(pattern, '');
            }
            return rs;
        }
    </script>
@endsection
