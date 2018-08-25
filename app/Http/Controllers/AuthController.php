<?php

namespace App\Http\Controllers;

use App\User;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                throw new CoreException('Invalid Credentials', 401);
            }

            $data = $this->responseWithToken($token);
            $response = Response::ok($data);
        } catch (CoreException $exception) {
            $response = Response::fail($exception);
        }

        return $response;
    }

    /**
     * @return array
     */
    public function logout()
    {
        try {

            JWTAuth::invalidate();
            $response = Response::ok([]);
        } catch (CoreException $exception) {
            $response = Response::fail($exception);
        }

        return $response;
    }

    /**
     * @return array
     */
    public function refresh()
    {
        try {

            $token = auth()->refresh();
            $data = $this->responseWithToken($token);
            $response = Response::ok($data);
        } catch (CoreException $exception) {
            $response = Response::fail($exception);
        }

        return $response;
    }

    /**
     * @param $token
     * @return array
     */
    public function responseWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }


    public function register(Request $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        return response([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

}
