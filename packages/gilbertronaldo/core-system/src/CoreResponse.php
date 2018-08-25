<?php

namespace GilbertRonaldo\CoreSystem;

/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/25/18
 * Time: 6:32 PM
 */

/**
 * Class CoreResponse
 * @package GilbertRonaldo\CoreSystem
 */
class CoreResponse
{
    /**
     * @param array $data
     * @return array
     */
    static public function ok($data = null)
    {
        return [
            'result' => [
                'status' => _RESPONSE_OK,
                'status_code' => 200,
                'data' => $data == null ? new \stdClass() : $data
            ]
        ];
    }

    /**
     * @param CoreException $ex
     * @return array
     *
     * 400 Bad Request
     * 401 UnAuthorized
     * 403 Forbidden
     * 500 Internal Server Error
     */
    static public function fail(CoreException $ex)
    {
        if (get_class($ex) == CoreException::class) {
            return [
                'result' => [
                    'status' => _RESPONSE_FAIL,
                    'status_code' => $ex->getCode(),
                    'data' => [
                        'message' => $ex->getMessage()
                    ]
                ]
            ];
        } else {
            return [
                'result' => [
                    'status' => _RESPONSE_FAIL,
                    'status_code' => 500,
                    'data' => [
                        'message' => 'Internal Server Error'
                    ]
                ]
            ];
        }
    }
}
