@extends('manage.layouts.app')

@section('title', '添加/管理分类')

@section('style')
    @parent
@endsection

@section('breadcrumb')
    <li navValue="nav_0"><a href="#">管理专区</a></li>
    <li navValue="nav_0_2"><a href="#">管理分类</a></li>
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
                添加/管理分类
            </header>
            <div class="panel-body">
                <form id="form" class="form-horizontal adminex-form" method="post" action="{{ $url }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="num" class="col-sm-2 col-sm-2 control-label">名称</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="num" name="num" value="{{ $old_input['num'] }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="commodity_id" class="col-sm-2 col-sm-2 control-label">房号</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="commodity_id" name="commodity_id">
                                @if(isset($old_input['commodity_id']))
                                    <option value="{{ $old_input['commodity_id'] }}">不修改</option>
                                @endif

                                @foreach($commodities as $commodity)
                                    <option value="{{ $commodity->id }}">{{ $commodity->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-sm-2 col-sm-2 control-label">状态</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="status" name="status">
                                @if(isset($old_input['status']))
                                    <option value="{{ $old_input['status'] }}">
                                        {{ config('site.room_status')[$old_input['status']] }}
                                    </option>
                                @endif
                                @foreach(config('site.room_status') as $key => $status)
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
    <script>
        $(document).ready(function () {
            $('#password').bind('input propertychange', function() {
                $(this).attr('name', 'password')
            });
        })
    </script>
@endsection
