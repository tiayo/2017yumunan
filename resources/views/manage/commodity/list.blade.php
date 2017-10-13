@extends('manage.layouts.app')

@section('title', '客房管理')

@section('style')
    @parent
@endsection

@section('breadcrumb')
    <li navValue="nav_1"><a href="#">客房管理</a></li>
    <li navValue="nav_1_1"><a href="#">客房类型</a></li>
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
		<section class="panel">
            <div class="panel-body">
                <form class="form-inline" id="search_form">
                    <div class="form-group">
                        <label class="sr-only" for="search"></label>
                        <input type="text" class="form-control" id="search" name="keyword"
                               value="{{ Request::get('keyword') }}" placeholder="输入商品名" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="salesman_search">搜索</button>
                </form>
            <header class="panel-heading">
                客房类型列表
            </header>
            	<table class="table table-striped table-hover">
		            <thead>
		                <tr>
		                    <th>ID</th>
		                    <th>名称</th>
		                    <th>价格</th>
		                    <th>数量</th>
                            <th>状态</th>
                            <th>分组</th>
                            <th>更新时间</th>
							<th>操作</th>
		                </tr>
		            </thead>

		            <tbody id="target">
                        @foreach($lists as $list)
                        <tr>
                            <td>{{ $list['id'] }}</td>
                            <td>{{ $list['name'] }}</td>
                            <td>{{ $list['price'] }}</td>
                            <td>{{ $list->room->where('status', 1)->count() }}</td>
                            <td>{{ config('site.commodity_status')[$list['status']] }}</td>
                            <td>{{ config('site.commodity_type')[$list['type']] }}</td>
                            <td>{{ $list['updated_at'] }}</td>
                            <td>
                                <button class="btn btn-warning" type="button" onclick="location='{{ route('commodity_status', ['id' => $list['id'] ]) }}'">上架/下架</button>
                                <button class="btn btn-success" type="button" onclick="location='{{ route('commodity_image', ['id' => $list['id'] ]) }}'">客房图片</button>
                                <button class="btn btn-info" type="button" onclick="location='{{ route('commodity_update', ['id' => $list['id'] ]) }}'">编辑</button>
                                <button class="btn btn-danger" type="button" onclick="javascript:if(confirm('确实要删除吗?'))location='{{ route('commodity_destroy', ['id' => $list['id'] ]) }}'">删除</button>
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

                window.location = '{{ route('commodity_search', ['keyword' => '']) }}/' + stripscript(keyword);

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
