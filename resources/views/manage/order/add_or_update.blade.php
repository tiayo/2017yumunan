@extends('manage.layouts.app')

@section('title', '添加/修改订单')

@section('style')
    @parent
@endsection

@section('breadcrumb')
    <li navValue="nav_3"><a href="#">订单管理</a></li>
    <li navValue="nav_3_2"><a href="#">添加/修改订单</a></li>
@endsection

@section('body')
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
            <header class="panel-heading">
                修改/添加订单
            </header>
            <div class="panel-body">
                <form id="form" class="form-horizontal adminex-form" method="post" action="{{ $url }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="commodity_id" class="col-sm-2 col-sm-2 control-label">入住房型</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="commodity_id" name="commodity_id">
                                @foreach($commodities as $commodity)
                                    <option value="{{ $commodity->id }}">{{ $commodity->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="num" class="col-sm-2 col-sm-2 control-label">房间数量</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="num" name="num"
                                   value="{{ $old_input['num'] or 1}}" placeholder="房间数量" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="day" class="col-sm-2 col-sm-2 control-label">入住天数</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="day" name="day"
                                   value="{{ $old_input['day'] or 1}}" placeholder="入住天数" required>
                        </div>
                    </div>

                    @if ($sign == 'add')
                        <div class="form-group">
                            <label for="id_number" class="col-sm-2 col-sm-2 control-label">身份证</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="id_number" name="id_number"
                                       value="{{ $old_input['id_number'] }}" placeholder="输入用户的身份证" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-sm-2 col-sm-2 control-label">电话</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="phone" name="phone"
                                       value="{{ $old_input['phone'] }}" placeholder="输入用户的电话" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_user" class="col-sm-2 col-sm-2 control-label">是否新用户</label>
                            <div class="col-sm-3 icheck minimal">
                                <div class="checkbox single-row">
                                    <input type="checkbox" name="new_user" id="new_user" value="1">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="remark" class="col-sm-2 col-sm-2 control-label">入住登记</label>
                        <div class="col-sm-3">
                            <textarea class="form-control" id="remark" name="remark" placeholder="输入所有入住人的身份证">{{ $old_input['remark'] }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-sm-2 col-sm-2 control-label">订单状态</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="status" name="status">
                                @foreach(config('site.order_status') as $key => $status)
                                    <option value="{{ $key }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div  class="col-sm-2 col-sm-2 control-label">
                            <button class="btn btn-success" type="submit"><i class="fa fa-cloud-upload"></i> 确认提交</button>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </div>
@endsection

@section('script')
    @parent
@endsection
