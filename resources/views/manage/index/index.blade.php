@extends('manage.layouts.app')

@section('title', '主页')

@section('style')
    <!--dashboard calendar-->
    <link href="{{ asset('/static/adminex/css/clndr.css') }}" rel="stylesheet">
    @parent
@endsection

@section('breadcrumb')

@endsection

@section('body')
    <div class="row">
        <div class="col-md-12">
            <!--statistics start-->
            <div class="row state-overview">
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <div class="panel purple">
                        <div class="symbol">
                            <i class="fa fa-home"></i>
                        </div>
                        <div class="state-value">
                            <div class="value">{{ $avalidate }}</div>
                            <div class="title">空房数量</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <div class="panel red">
                        <div class="symbol">
                            <i class="fa fa-key"></i>
                        </div>
                        <div class="state-value">
                            <div class="value">{{ $unavailable }}</div>
                            <div class="title">住房数量</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4">
                    <div class="panel blue">
                        <div class="symbol">
                            <i class="fa fa-first-order"></i>
                        </div>
                        <div class="state-value">
                            <div class="value">{{ $order_count }}</div>
                            <div class="title">完成的订单</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--statistics end-->
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    最新订单
                    <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                </header>
                <div class="panel-body">
                    <section id="unseen">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>用户</th>
                                <th>客房</th>
                                <th>数量</th>
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
                                    <td>{{ $list['num'] }}</td>
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
                    </section>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <!--Calendar-->
    <script src="{{ asset('/static/adminex/js/calendar/clndr.js') }}"></script>
    <script src="{{ asset('/static/adminex/js/calendar/evnt.calendar.init.js') }}"></script>
    <script src="{{ asset('/static/adminex/js/calendar/moment-2.2.1.js') }}"></script>
    <script src="{{ asset('http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js') }}"></script>

@endsection
