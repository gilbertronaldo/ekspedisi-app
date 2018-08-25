<?php

namespace App\Http\Controllers;

use App\User;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
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
     * Create a new AuthController instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login']]);
//    }

    /**
     * Get the authenticated User.
     *
     * @return array
     */
    public function me()
    {
        try {

            if (auth()->check()) {
                $data = auth()->user();
            } else {
                throw new CoreException('Invalid Credentials', 401);
            }

            $response = CoreResponse::ok($data);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }


    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!$token = auth()->attempt($credentials)) {
                throw new CoreException('Invalid Credentials', 401);
            }

            $data = $this->responseWithToken($token);
            $response = CoreResponse::ok($data);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return array
     */
    public function logout()
    {
        try {

            auth()->invalidate();
            $response = CoreResponse::ok();
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * Refresh a token.
     *
     * @return array
     */
    public function refresh()
    {
        try {

            $token = auth()->refresh();
            $data = $this->responseWithToken($token);
            $response = CoreResponse::ok($data);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * Get the token array structure.
     *
     * @param $token
     * @return array
     */
    private function responseWithToken($token)
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
