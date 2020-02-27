<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;
use App\Order;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', []);
    }

    public function orders()
    {
        // list order yang telah di bayar dan belum
    }

}
