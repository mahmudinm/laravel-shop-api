<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {

    $api->resource('product', 'App\\Api\\V1\\Controllers\\ProductController');

    $api->get('checkout', 'App\\Api\\V1\\Controllers\\CheckoutController@index');
    $api->get('checkout/city/{city}', 'App\\Api\\V1\\Controllers\\CheckoutController@getCity');
    $api->get('checkout/district/{district}', 'App\\Api\\V1\\Controllers\\CheckoutController@getDistrict');

    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');
    });

    $api->group(['middleware' => ['jwt.auth', 'admin'], 'prefix' => 'admin'], function(Router $api) {
        $api->get('product/create', 'App\\Api\\V1\\Controllers\\Admin\\ProductController@create');
        $api->get('product/{id}/edit', 'App\\Api\\V1\\Controllers\\Admin\\ProductController@edit');
        $api->resource('product', 'App\\Api\\V1\\Controllers\\Admin\\ProductController');

        $api->get('category/{id}/edit', 'App\\Api\\V1\\Controllers\\Admin\\CategoryController@edit');
        $api->resource('category', 'App\\Api\\V1\\Controllers\\Admin\\CategoryController');
    });

});
