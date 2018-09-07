<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/31/18
 * Time: 10:16 PM
 */

namespace App\Http\Controllers;


use App\MsCity;
use App\MsShip;
use Carbon\Carbon;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;

class ShipController extends Controller
{
    public function all(Request $request)
    {
//        $data = MsShip::select('ms_ship.ship_id', 'ms_ship.ship_name', 'ms_ship.ship_description',  'ms_ship.no_voyage',
//            'B.city_code AS city_code_from', 'C.city_code AS city_code_to',
//            DB::raw("to_char(ms_ship.sailing_date, 'DD FMMonth YYYY') as sailing_date"))
//            ->join('ms_city as B', 'B.city_id', '=', 'ms_ship.city_id_from', 'left outer')
//            ->join('ms_city as C', 'C.city_id', '=', 'ms_ship.city_id_to', 'left outer')
//            ->get();

        $ships = MsShip::get();
        foreach ($ships as $ship) {
            $ship->city_code_from = $ship->cityFrom->city_code;
            $ship->city_code_to = $ship->cityTo->city_code;
        }


            $query = DB::TABLE(DB::RAW("(
            SELECT 
              A.ship_id, 
              A.ship_name,
              A.ship_description,
              to_char(A.sailing_date, 'DD FMMonth YYYY') AS sailing_date,
              A.no_voyage,
              B.city_code || ' - ' || C.city_code AS destination
            FROM ms_ship A
            LEFT OUTER JOIN ms_city B 
             ON A.city_id_from = B.city_id
             AND B.deleted_at IS NULL
            LEFT OUTER JOIN ms_city C
             ON A.city_id_to = C.city_id
             AND C.deleted_at IS NULL
            WHERE A.deleted_at IS NULL
        ) AS X"));
        return datatables()->of($ships)->toJson();
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
            if ($request->has('ship_id')) {
                $ship = MsShip::findOrFail($request->input('ship_id'));
            } else {
                $ship = new MsShip();
            }

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
