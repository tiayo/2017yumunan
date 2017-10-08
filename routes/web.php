<?php

$this->group(['namespace' => 'Home'], function () {
    //登录注册
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('home.login');
    $this->post('login', 'Auth\LoginController@login');
    $this->get('logout', 'Auth\LoginController@logout')->name('home.logout');

    $this->get('/', 'IndexController@index')->name('home.index');
    $this->get('/search', 'IndexController@search')->name('home.search');
    $this->get('/commodity/{id}', 'DetailController@view')->name('home.commodity_view');
    $this->get('/category/{id}', 'ListController@view')->name('home.category_view');

    //登录后操作
    $this->group(['middleware' => 'manage_auth'], function () {
        $this->get('/car/list', 'CarController@view')->name('home.car');
        $this->post('/car/add/{commodity_id}', 'CarController@add')->name('home.car_add');
        $this->get('/car/destory/{commodity_id}', 'CarController@destory')->name('home.car_destory');
        $this->get('/order/add', 'OrderController@add')->name('home.order_add');
    });
});
