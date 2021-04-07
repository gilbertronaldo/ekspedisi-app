<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/31/18
 * Time: 10:16 PM
 */

namespace App\Http\Controllers;


use App\Exports\ShipLangsungTagihExports;
use App\MsCity;
use App\MsRecipient;
use App\MsShip;
use App\TrBapb;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Contracts\DataTable;

/**
 * Class ShipController
 *
 * @package App\Http\Controllers
 */
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
            $ship->city_code_from = $ship->cityFrom ? $ship->cityFrom->city_code
                : '';
            $ship->city_code_to = $ship->cityTo ? $ship->cityTo->city_code
                : '';
        }

        return datatables()->of($ships)->toJson();
    }

    public function get($id = -99)
    {
        try {
            if ($id == -99) {
                $ship = MsShip::get();
                foreach ($ship as $s) {
                    $s->city_code_from = $s->cityFrom ? $s->cityFrom->city_code
                        : '';
                    $s->city_code_to = $s->cityTo ? $s->cityTo->city_code
                        : '';
                }
            } else {
                $ship = MsShip::findOrFail($id);
                $ship->city_code_from = $ship->cityFrom
                    ? $ship->cityFrom->city_code : '';
                $ship->city_code_to = $ship->cityTo ? $ship->cityTo->city_code
                    : '';
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
                $ship->city_code_from = $ship->cityFrom
                    ? $ship->cityFrom->city_code : '';
                $ship->city_code_to = $ship->cityTo ? $ship->cityTo->city_code
                    : '';
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

                $existNoVoyage = MsShip::where(
                    "no_voyage",
                    "=",
                    str_replace(' ', '', strtoupper($request->input('no_voyage')))
                )
                    ->first();

                if ($existNoVoyage) {
                    throw new CoreException("Nomor Voyage Kapal sudah ada !");
                }
            }

            $ship->no_voyage = str_replace(
                ' ',
                '',
                strtoupper($request->input('no_voyage'))
            );
            $ship->ship_name = strtoupper($request->input('ship_name'));
            $ship->ship_description = $request->input('ship_description');
            $ship->sailing_date = Carbon::parse(
                $request->input('sailing_date')
            );
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

            $exist = TrBapb::query()
                ->select('ship_id')
                ->where('ship_id', '=', $shipId)
                ->exists();

            if ($exist) {
                throw new CoreException('Kapal telah diinput di BAPB');
            } else {
                $ship->delete();
            }

            $response = CoreResponse::ok($ship);
        } catch (CoreException $e) {
            $response = CoreResponse::fail($e);
        }

        return $response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function searchContainer(Request $request)
    {
        try {

            $query = DB::table('tr_bapb')
                ->select([
                    DB::raw(" UPPER(CONCAT(tr_bapb.no_container_1, ' ', tr_bapb.no_container_2)) AS no_container"),
                    DB::raw(" UPPER(tr_bapb.no_container_1) AS no_container_1"),
                    DB::raw(" UPPER(tr_bapb.no_container_2) AS no_container_2"),
                    DB::raw(' FALSE AS checked'),
                ])
                ->whereNull('tr_bapb.deleted_at')
                ->groupBy([
                    'tr_bapb.no_container_1',
                    'tr_bapb.no_container_2',
                ]);

            if ($request->has('ship_id')) {
                $query = $query
                    ->where('tr_bapb.ship_id', '=', $request->input('ship_id'));
            } else if ($request->has('recipient_id')) {
                $query = $query
                    ->where('tr_bapb.recipient_id', '=', $request->input('recipient_id'));
            }

            $containerList = $query->get();

            $containerList = $containerList->unique();

            $response = CoreResponse::ok(compact('containerList'));
        } catch (CoreException $e) {
            $response = CoreResponse::fail($e);
        }

        return $response;
    }

    public function exportExcelLangsungTagih($id)
    {
        $ship = MsShip::findOrFail($id);

        return Excel::download(new ShipLangsungTagihExports($id), 'ship_' . $ship->no_voyage . '.xlsx');
    }

    public function departureList(Request $request)
    {
        $query = TrBapb::query()
            ->select([
                'ms_ship.ship_id',
                'ms_ship.no_voyage',
                'ms_ship.ship_name',
                DB::raw("to_char(ms_ship.sailing_date, 'dd FMMonth yyyy') as sailing_date"),
                'ms_recipient.recipient_id',
                'ms_recipient.recipient_name',
            ])
            ->join('ms_ship', static function (JoinClause $clause) {
                $clause->on('ms_ship.ship_id', '=', 'tr_bapb.ship_id');
                $clause->whereNull('ms_ship.deleted_at');
            })
            ->join('ms_recipient', static function (JoinClause $clause) {
                $clause->on('ms_recipient.recipient_id', '=', 'tr_bapb.recipient_id');
                $clause->whereNull('ms_recipient.deleted_at');
            })
            ->toSql();

        return datatables()->of(DB::TABLE(DB::RAW("(" . $query . ") AS X")))->make();
    }

    /**
     * @param $shipId
     * @param $recipientId
     *
     * @throws \Exception
     */
    public function departurePrint($shipId, $recipientId)
    {
        try {

            $recipient = MsRecipient::findOrFail($recipientId);
            $ship = MsShip::findOrFail($shipId);

            $items = TrBapb::query()
                ->select([
                    'no_container_1',
                    'no_container_2',
                    'ms_sender.sender_name_bapb',
//                    'tr_bapb_sender_item.bapb_sender_item_name',
                    DB::raw('SUM(tr_bapb_sender_item.koli) AS koli'),
                ])
                ->join('tr_bapb_sender', static function (JoinClause $clause) {
                    $clause->on('tr_bapb_sender.bapb_id', '=', 'tr_bapb.bapb_id');
                    $clause->whereNull('tr_bapb_sender.deleted_at');
                })
                ->join('ms_sender', static function (JoinClause $clause) {
                    $clause->on('ms_sender.sender_id', '=', 'tr_bapb_sender.sender_id');
                    $clause->whereNull('ms_sender.deleted_at');
                })
                ->join('tr_bapb_sender_item', static function (JoinClause $clause) {
                    $clause->on('tr_bapb_sender_item.bapb_sender_id', '=', 'tr_bapb_sender.bapb_sender_id');
                    $clause->whereNull('tr_bapb_sender_item.deleted_at');
                })
                ->where('ship_id', '=', $ship->ship_id)
                ->where('recipient_id', '=', $recipient->recipient_id)
                ->groupBy([
                    'no_container_1',
                    'no_container_2',
                    'ms_sender.sender_name_bapb',
//                    'tr_bapb_sender_item.bapb_sender_item_name',
//                    'tr_bapb_sender_item.koli',
                ])
                ->get();

            $codes = [
                [
                    'city'      => 'BPP',
                    'city_full' => 'Balikpapan',
                    'name'      => 'Bpk ACO',
                    'phone'     => '0852 4690 1000',
                ],
                [
                    'city'      => 'SMD',
                    'city_full' => 'Samarinda',
                    'name'      => 'Bpk Supri',
                    'phone'     => '0821 1155 0943',
                ],
                [
                    'city'      => 'BJM',
                    'city_full' => 'Banjarmasin',
                    'name'      => 'Bpk Birin',
                    'phone'     => '0813 4538 8506',
                ],
                [
                    'city'      => 'MKS',
                    'city_full' => 'Makassar',
                    'name'      => 'Bpk Yanto',
                    'phone'     => '0852 4290 2538',
                ],
            ];

            $contact = collect($codes)
                ->where('city', '=', $ship->cityFrom->city_code)
                ->first();
            if (! $contact) {
                $contact = collect($codes)
                    ->where('city', '=', $ship->cityTo->city_code)
                    ->first();
            }

            $input = [
                'recipient' => $recipient,
                'ship'      => $ship,
                'items'     => $items,
                'contact'   => $contact,
            ];
            $pdf = PDF::loadView('ship.pdf.print', $input);

            return $pdf->stream('ship_' . $ship->no_voyage . '.pdf');
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
