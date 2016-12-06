<?php
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['namespace' => 'App\Api\V1', ['middleware' => 'cors']], function ($api) {

    $api->get('ping', function () {
        return 'alive';
    });

    $api->post('authorization', 'AuthController@login');
    $api->post('refresh', 'AuthController@refresh');

    // 需要授权
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        // 当前登录
        $api->get('me', 'AuthController@me');
        $api->get('users', 'UserController@index');
        $api->post('users', 'UserController@create');
    });
});
