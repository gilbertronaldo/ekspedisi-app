<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/9/19
 * Time: 12:47 PM
 */

namespace App\Http\Controllers;


use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * get new bapb no
     *
     * @return array
     */
    public function init()
    {
        try {

            $user = auth()->user();

            $res = [
              'user'  => $user,
              'tasks' => [],
            ];

            $response = CoreResponse::ok($res);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}
