<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/25/18
 * Time: 8:15 PM
 */

namespace GilbertRonaldo\CoreSystem;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class CoreHandler
 * @package GilbertRonaldo\CoreSystem
 */
class CoreHandler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Exception $exception
     * @return void
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->is('api/*')) {
            switch (get_class($exception)) {
                case MethodNotAllowedHttpException::class:
                    return response()->json($this->jsonResponse(405, 'Method Not Allowed'));
                    break;
                case NotFoundHttpException::class:
                    return response()->json($this->jsonResponse(404, 'Method Not Found'));
                default:
                    return response()->json($this->jsonResponse($exception->getCode(), $exception->getMessage()));
                    break;
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * @param int $code
     * @param string $message
     * @return array
     */
    private function jsonResponse(int $code, string $message)
    {
        return [
            'result' => [
                'status' => _RESPONSE_FAIL,
                'status_code' => $code == 0 ? 400 : $code,
                'data' => [
                    'message' => $message == '' ? 'An error occurred' : $message
                ]
            ]
        ];
    }
}
