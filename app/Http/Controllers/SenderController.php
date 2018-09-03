<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/31/18
 * Time: 11:36 PM
 */

namespace App\Http\Controllers;


use App\MsSender;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;

class SenderController
{
    public function paginate(Request $request)
    {
        try {

            $senderList = MsSender::paginate();

            $response = CoreResponse::ok($senderList);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function store(Request $request)
    {
        try {

            $response = CoreResponse::ok();
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function destroy(Request $request)
    {
        try {

            $response = CoreResponse::ok();
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}