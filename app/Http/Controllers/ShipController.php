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
            $ship->city_code_from = $ship->cityFrom ? $ship->cityFrom->city_code : '';
            $ship->city_code_to = $ship->cityTo ? $ship->cityTo->city_code : '';
        }

        return datatables()->of($ships)->toJson();
    }

    public function get($id = -99)
    {
        try {
            if ($id == -99) {
                $ship = MsShip::get();
                foreach ($ship as $s) {
                    $s->city_code_from = $s->cityFrom ? $s->cityFrom->city_code : '';
                    $s->city_code_to = $s->cityTo ? $s->cityTo->city_code : '';
                }
            } else {
                $ship = MsShip::findOrFail($id);
                $ship->city_code_from = $ship->cityFrom ? $ship->cityFrom->city_code : '';
                $ship->city_code_to = $ship->cityTo ? $ship->cityTo->city_code : '';
            }
            $response = CoreResponse::ok($ship);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function search(Request $request)
    {
        try {
            $text = (string)$request->input('text');
            $page = (int)$request->input('page');
            $limit = (int)$request->input('limit');
            
            $shipList = MsShip::where('ship_name', 'ilike', "%$text%")
                ->orWhere('no_voyage', 'ilike', "%$text%")
                ->offset($page - 1)
                ->limit($limit)
                ->get();
            $count = MsShip::where('ship_name', 'ilike', "%$text%")
                ->orWhere('no_voyage', 'ilike', "%$text%")
                ->count();

            foreach ($shipList as $ship) {
                $ship->city_code_from = $ship->cityFrom ? $ship->cityFrom->city_code : '';
                $ship->city_code_to = $ship->cityTo ? $ship->cityTo->city_code : '';
            }
            $response = CoreResponse::ok(compact('shipList', 'count'));
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('ship_id')) {
                $ship = MsShip::findOrFail($request->input('ship_id'));
            } else {
                $ship = new MsShip();

                $existNoVoyage = MsShip::where("no_voyage", "=", str_replace(' ', '', strtoupper($request->input('no_voyage'))))
                    ->first();

                if ($existNoVoyage) {
                    throw new CoreException("Nomor Voyage Kapal sudah ada !");
                }
            }

            $ship->no_voyage = str_replace(' ', '', strtoupper($request->input('no_voyage')));
            $ship->ship_name = strtoupper($request->input('ship_name'));
            $ship->ship_description = $request->input('ship_description');
            $ship->sailing_date = Carbon::parse($request->input('sailing_date'));
            $ship->city_id_from = $request->input('city_id_from');
            $ship->city_id_to = $request->input('city_id_to');
            $ship->save();

            DB::commit();
            $response = CoreResponse::ok($ship);
        } catch (CoreException $e) {
            DB::rollBack();
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
