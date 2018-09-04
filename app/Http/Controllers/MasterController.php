<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 9/3/18
 * Time: 6:32 PM
 */

namespace App\Http\Controllers;

use App\MsCity;
use App\MsCountry;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function cityList(Request $request)
    {
        try {

            $cityList = MsCity::all();

            $response = CoreResponse::ok($cityList);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function countryList(Request $request)
    {
        try {
            $countryList = MsCountry::all();

            $response = CoreResponse::ok($countryList);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}
