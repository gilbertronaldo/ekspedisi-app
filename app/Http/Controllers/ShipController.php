<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/31/18
 * Time: 10:16 PM
 */

namespace App\Http\Controllers;


use App\MsShip;
use Carbon\Carbon;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;

class ShipController extends Controller
{
    public function all(Request $request)
    {
        return datatables(MsShip::all())->toJson();
    }

    public function get($id)
    {
        try {
            $ship = MsShip::findOrFail($id);
            $response = CoreResponse::ok($ship);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
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
            $ship->sailing_date = Carbon::parse($request->input('sailing_date'));
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
