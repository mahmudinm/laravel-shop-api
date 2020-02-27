<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {

    $api->get('/', 'App\\Api\\V1\\Controllers\\HomeController@index');
    $api->get('product', 'App\\Api\\V1\\Controllers\\ProductController@index');
    $api->get('product/{id}', 'App\\Api\\V1\\Controllers\\ProductController@show');

    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\Auth\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\Auth\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\Auth\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\Auth\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\Auth\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\Auth\\RefreshController@refresh');
    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('checkout', 'App\\Api\\V1\\Controllers\\CheckoutController@index');
        $api->post('checkout', 'App\\Api\\V1\\Controllers\\CheckoutController@store');
        $api->get('checkout/city/{city}', 'App\\Api\\V1\\Controllers\\CheckoutController@getCity');
        $api->get('checkout/district/{district}', 'App\\Api\\V1\\Controllers\\CheckoutController@getDistrict');

        $api->get('payment/{invoice}', 'App\\Api\\V1\\Controllers\\PaymentController@index');
        $api->post('payment', 'App\\Api\\V1\\Controllers\\PaymentController@store');
    });

    $api->group(['middleware' => ['jwt.auth', 'admin'], 'prefix' => 'admin'], function(Router $api) {
        $api->get('product/create', 'App\\Api\\V1\\Controllers\\Admin\\ProductController@create');
        $api->get('product/{id}/edit', 'App\\Api\\V1\\Controllers\\Admin\\ProductController@edit');
        $api->resource('product', 'App\\Api\\V1\\Controllers\\Admin\\ProductController');

        $api->get('category/{id}/edit', 'App\\Api\\V1\\Controllers\\Admin\\CategoryController@edit');
        $api->resource('category', 'App\\Api\\V1\\Controllers\\Admin\\CategoryController');

        $api->resource('order', 'App\\Api\\V1\\Controllers\\Admin\\OrderController', ['only' => ['index', 'destroy']]);
    });

});
