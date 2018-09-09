<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/31/18
 * Time: 11:36 PM
 */

namespace App\Http\Controllers;

use App\TrBapb;
use Carbon\Carbon;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;

class BapbController
{
    /**
     * get new bapb no
     * @return array
     */
    public function no()
    {
        try {
            $bapbNo = $this->newBapbNo();
            $response = CoreResponse::ok($bapbNo);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function get(Request $request)
    {
        try {
            $response = CoreResponse::ok();
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

    /**
     * get new bapb_no
     * @return string
     */
    private function newBapbNo() {
        $year = Carbon::now()->format('y');

        $bapb = TrBapb::whereRaw("LEFT(bapb_no, 2) = '$year'")
            ->selectRaw('CAST(RIGHT(bapb_no, 8) AS INT) AS bapb_no')
            ->orderBy('bapb_no', 'desc')
            ->first();

        if (!$bapb) {
            return $year.str_pad(1, 8, '0', STR_PAD_LEFT);
        }

        return $year.str_pad($bapb->bapb_no + 1, 8, '0', STR_PAD_LEFT);
    }
}
