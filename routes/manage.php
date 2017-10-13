<?php

$this->group(['namespace' => 'Manage', 'prefix' => 'manage'], function () {
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('manage.login');
    $this->post('login', 'Auth\LoginController@login')->name('manage.login');
    $this->get('logout', 'Auth\LoginController@logout')->name('manage.logout');

    //登陆后才可以访问
    $this->group(['middleware' => 'manage_auth'], function () {

        $this->get('/', 'IndexController@index')->name('manage');

        //管理员才可以操作
        $this->group(['middleware' => 'admin'], function () {
            //房间相关
            $this->get('/room/list/', 'RoomController@listView')->name('room_list');
            $this->get('/room/list/{keyword}', 'RoomController@listView')->name('room_search');
            $this->get('/room/add', 'RoomController@addView')->name('room_add');
            $this->post('/room/add', 'RoomController@post');
            $this->get('/room/update/{id}', 'RoomController@updateView')->name('room_update');
            $this->post('/room/update/{id}', 'RoomController@post');
            $this->get('/room/destroy/{id}', 'RoomController@destroy')->name('room_destroy');

            //商品相关
            $this->get('/commodity/list/', 'CommodityController@listView')->name('commodity_list');
            $this->get('/commodity/list/{keyword}', 'CommodityController@listView')->name('commodity_search');
            $this->get('/commodity/add', 'CommodityController@addView')->name('commodity_add');
            $this->post('/commodity/add', 'CommodityController@post');
            $this->get('/commodity/update/{id}', 'CommodityController@updateView')->name('commodity_update');
            $this->post('/commodity/update/{id}', 'CommodityController@post');
            $this->get('/commodity/status/{id}', 'CommodityController@changeStatus')->name('commodity_status');
            $this->get('/commodity/destroy/{id}', 'CommodityController@destroy')->name('commodity_destroy');
            $this->get('/commodity/image/{id}', 'CommodityController@uploadImage')->name('commodity_image');
            $this->post('/commodity/image/{id}', 'CommodityController@uploadImagePost');

            //会员相关
            $this->get('/user/list/', 'UserController@listView')->name('user_list');
            $this->get('/user/list/{keyword}', 'UserController@listView')->name('user_search');
            $this->get('/user/update/{id}', 'UserController@updateView')->name('user_update');
            $this->post('/user/update/{id}', 'UserController@post');
            $this->get('/user/destroy/{id}', 'UserController@destroy')->name('user_destroy');

            //订单管理
            $this->get('/order/list/', 'OrderController@listView')->name('order_list');
            $this->get('/order/list/{keyword}', 'OrderController@listView')->name('order_search');
            $this->get('/order/update/{order_id}', 'OrderController@updateView')->name('order_update');
            $this->post('/order/update/{order_id}', 'OrderController@post');
            $this->get('/order/add', 'OrderController@addView')->name('order_add');
            $this->post('/order/add', 'OrderController@post');
            $this->get('/order/destroy/{order_id}', 'OrderController@destroy')->name('order_destroy');
            $this->get('/order/status/{order_id}/{status}', 'OrderController@changeStatus')->name('order_status');
        });
    });
});