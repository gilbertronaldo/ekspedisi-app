<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/9/19
 * Time: 12:23 AM
 */

namespace App\Http\Controllers;


use App\TrBapb;
use App\TrInvoice;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{

    /**
     * get new bapb no
     *
     * @return array
     */
    public function header()
    {
        try {
            $total    = [
              'staff'   => 0,
              'bapb'    => TrBapb::all()->count(),
              'invoice' => TrInvoice::all()->count(),
              'profit'  => 0,
            ];
            $response = CoreResponse::ok(compact('total'));
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}
