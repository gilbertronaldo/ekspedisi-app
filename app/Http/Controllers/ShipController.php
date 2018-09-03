<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/31/18
 * Time: 10:16 PM
 */

namespace App\Http\Controllers;


use App\MsShip;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    public function get(Request $request)
    {
        try {

            $shipList = MsShip::all();
            $response = CoreResponse::ok($shipList);
        } catch (CoreException $e) {
            $response = CoreResponse::fail($e);
        }

        return $response;
    }

    public function store(Request $request)
    {
        try {
            $ship = new MsShip();
            $ship->no_voyage = $request->input('no_voyage');
            $ship->ship_name = $request->input('ship_name');
            $ship->ship_description = $request->input('ship_description');
            $ship->city_id_from = $request->input('city_id_from');
            $ship->city_id_to = $request->input('city_id_to');
            $ship->save();

            $response = CoreResponse::ok($ship);
        } catch (CoreException $e) {
            $response = CoreResponse::fail($e);
        }

        return $response;
    }

    public function destroy($shipId)
    {
        try {
            $ship = MsShip::findOrFail($shipId);
            $ship->delete();

            $response = CoreResponse::ok($ship);
        } catch (CoreException $e) {
            $response = CoreResponse::fail($e);
        }

        return $response;
    }
}
