<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/31/18
 * Time: 11:36 PM
 */

namespace App\Http\Controllers;

use App\Exports\BapbExport;
use App\MsSender;
use App\TrBapb;
use App\TrBapbSender;
use App\TrBapbSenderCost;
use App\TrBapbSenderItem;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class BapbController extends Controller
{

    public $berat = 0;

    public $dimensi = 0;

    /**
     * get new bapb no
     *
     * @return array
     */
    public function no($code)
    {
        try {
            $bapbNo = $this->newBapbNo($code);
            $response = CoreResponse::ok($bapbNo);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * get new bapb no
     *
     * @return array
     */
    public function nextId()
    {
        try {
            $bapbNo = DB::select(
                "
                SELECT last_value FROM tr_bapb_bapb_id_seq;
            "
            );
            $response = CoreResponse::ok($bapbNo[0]->last_value + 1);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
    public function all(Request $request)
    {
        //        $bapbList = TrBapb::with('senders.items')
        //            ->with('senders.costs')
        //            ->with('recipient')
        //            ->with('ship')
        //            ->get();
        //
        //        $bapbList->each(function ($i) {
        //            $i->no_container = $i->no_container_1 . " " . $i->no_container_2;
        //
        //            $i->no_ttb = $i->senders->map(function ($j) {
        //                return $j->no_ttb;
        //            });
        //        });

        $query = "
          SELECT A.bapb_id, A.bapb_no, CONCAT(A.no_container_1, ' ', A.no_container_2) as no_container,
                 A.no_seal, A.verified,
              B.no_voyage, C.recipient_name_bapb, string_agg(D.no_ttb, ', ') as no_ttb,
                 string_agg(DISTINCT E.sender_name_bapb, ', ') as senders,
              COALESCE(A.harga,0) + COALESCE(A.cost,0) AS total,
              B.ship_name, to_char(B.sailing_date, 'dd/mm/yy') as sailing_date,
              G.name AS creator,
              tr_invoice.invoice_no
            FROM tr_bapb A
            INNER JOIN ms_ship B
              ON A.ship_id = B.ship_id
              AND B.deleted_at IS NULL
            INNER JOIN ms_recipient C
              ON A.recipient_id = C.recipient_id
              AND C.deleted_at IS NULL
            LEFT JOIN tr_bapb_sender D
              ON A.bapb_id = D.bapb_id
              AND D.deleted_at IS NULL
            LEFT JOIN ms_sender E
              ON D.sender_id = E.sender_id
              AND E.deleted_at IS NULL
            LEFT JOIN audits F
                ON F.auditable_id = A.bapb_id
                AND F.auditable_type = 'App\TrBapb'
                AND F.event = 'created'
            LEFT JOIN users G
                ON G.id = F.user_id
            LEFT JOIN tr_invoice_bapb
                ON A.bapb_id = tr_invoice_bapb.bapb_id
                AND tr_invoice_bapb.deleted_at IS NULL
            LEFT JOIN tr_invoice
                ON tr_invoice.invoice_id = tr_invoice_bapb.invoice_id
                AND tr_invoice.deleted_at IS NULL
            WHERE A.deleted_at IS NULL
            GROUP BY A.bapb_id, A.bapb_no, no_container, no_seal, no_voyage, recipient_name_bapb,
                     A.harga, A.berat, B.ship_name, B.sailing_date, G.name, tr_invoice.invoice_no
        ";

        return DataTables::of(DB::TABLE(DB::RAW("(" . $query . ") AS X")))->make();
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function get($id)
    {
        try {
            $bapb = TrBapb::with('senders.items')
                ->with('senders.costs')
                ->findOrFail($id);
            foreach ($bapb->senders as $sender) {
                $sender->detail = MsSender::with('city')->find(
                    $sender->sender_id
                );

                if (! is_null($sender->detail) && ! is_null($sender->detail->city)) {
                    $sender->detail->city_name = $sender->detail->city->city_name;
                }
            }
            $response = CoreResponse::ok($bapb);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->has('bapb_id')) {
                $bapb = TrBapb::findOrFail($request->input('bapb_id'));
            } else {
                $bapb = new TrBapb();
                $bapb->bapb_no = $request->input('bapb_no');
            }
            $bapb->bapb_description = $request->input('bapb_description');
            $bapb->no_container_1 = $request->input('no_container_1');
            $bapb->no_container_2 = $request->input('no_container_2');
            $bapb->no_seal = $request->input('no_seal');
            $bapb->tagih_di = $request->input('tagih_di');
            $bapb->langsung_tagih = $request->input('langsung_tagih');
            $bapb->ship_id = $request->input('ship_id');
            $bapb->recipient_id = $request->input('recipient_id');
            $bapb->show_calculation = $request->input('show_calculation');
            $bapb->show_price = $request->input('show_price');
            $bapb->squeeze = $request->has('squeeze') ? ! is_null($request->input('squeeze')) ? $request->input('squeeze') : false : false;

            $bapb->full_container = $request->input('full_container');
            $bapb->full_container_data = $request->input('full_container_data');

            $bapb->tagih_jkt = $request->input('tagih_jkt');

            $total = $request->input('total');
            $bapb->harga = isset($total['harga']) ? $total['harga'] : 0;
            $bapb->cost = isset($total['cost']) ? $total['cost'] : 0;
            $bapb->dimensi = isset($total['dimensi']) ? $total['dimensi'] : 0;
            $bapb->berat = isset($total['berat']) ? $total['berat'] : 0;
            $bapb->koli = isset($total['koli']) ? $total['koli'] : 0;

            $bapb->save();

            if ($bapb->full_container) {
                TrBapbSenderCost::query()
                    ->join('tr_bapb_sender', static function (JoinClause $clause) {
                        $clause->on('tr_bapb_sender.bapb_sender_id', '=', 'tr_bapb_sender_cost.bapb_sender_id');
                    })
                    ->where('bapb_id', '=', $bapb->bapb_id)
                    ->delete();

                TrBapbSenderItem::query()
                    ->join('tr_bapb_sender', static function (JoinClause $clause) {
                        $clause->on('tr_bapb_sender.bapb_sender_id', '=', 'tr_bapb_sender_item.bapb_sender_id');
                    })
                    ->where('bapb_id', '=', $bapb->bapb_id)
                    ->delete();

                TrBapbSender::query()
                    ->where('bapb_id', '=', $bapb->bapb_id)
                    ->delete();

                foreach ($bapb->full_container_data['items'] as $item) {
                    $bapbSender = new TrBapbSender();
                    $bapbSender->bapb_id = $bapb->bapb_id;
                    $bapbSender->sender_id = $item['sender_id'];
                    $bapbSender->save();
                }
            } else {

                $unDeletedSender = [];
                $unDeletedItem = [];
                $unDeletedCost = [];
                foreach ($request->input('senders') as $sender) {
                    if (isset($sender['bapb_sender_id'])) {
                        $bapbSender = TrBapbSender::findOrFail(
                            $sender['bapb_sender_id']
                        );
                    } else {
                        $bapbSender = new TrBapbSender();
                    }
                    $bapbSender->bapb_id = $bapb->bapb_id;
                    $bapbSender->sender_id = $sender['sender_id'];
                    $bapbSender->kemasan = isset($sender['kemasan'])
                        ? $sender['kemasan'] : null;
                    $bapbSender->krani = isset($sender['krani'])
                        ? $sender['krani'] : null;
                    $bapbSender->no_ttb = isset($sender['no_ttb'])
                        ? $sender['no_ttb'] : null;
                    $bapbSender->description = isset($sender['description'])
                        ? $sender['description'] : null;
                    $bapbSender->entry_date = isset($sender['entry_date'])
                        ? Carbon::parse($sender['entry_date']) : null;
                    $bapbSender->price = isset($sender['total_price'])
                        ? $sender['total_price'] : 0;
                    $bapbSender->dimensi = $sender['total_dimensi'];
                    $bapbSender->berat = $sender['total_berat'];
                    $bapbSender->save();

                    $unDeletedSender[] = $bapbSender->bapb_sender_id;
                    foreach ($sender['items'] as $item) {
                        if (isset($item['bapb_sender_item_id'])) {
                            $bapbSenderItem = TrBapbSenderItem::findOrFail(
                                $item['bapb_sender_item_id']
                            );
                        } else {
                            $bapbSenderItem = new TrBapbSenderItem();
                        }
                        $bapbSenderItem->bapb_sender_id
                            = $bapbSender->bapb_sender_id;
                        $bapbSenderItem->bapb_sender_item_name
                            = $item['bapb_sender_item_name'];
                        $bapbSenderItem->koli = $item['koli'];
                        $bapbSenderItem->panjang = $item['panjang'];
                        $bapbSenderItem->lebar = $item['lebar'];
                        $bapbSenderItem->tinggi = $item['tinggi'];
                        $bapbSenderItem->berat = $item['berat'];
                        $bapbSenderItem->price
                            = isset($item['price'])
                            ? $item['price'] : 0;
                        $bapbSenderItem->save();

                        $unDeletedItem[] = $bapbSenderItem->bapb_sender_item_id;
                    }

                    foreach ($sender['costs'] as $cost) {
                        if (isset($cost['bapb_sender_cost_id'])) {
                            $bapbSenderCost = TrBapbSenderCost::findOrFail(
                                $cost['bapb_sender_cost_id']
                            );
                        } else {
                            $bapbSenderCost = new TrBapbSenderCost();
                        }
                        $bapbSenderCost->bapb_sender_id
                            = $bapbSender->bapb_sender_id;
                        $bapbSenderCost->bapb_sender_cost_name
                            = $cost['bapb_sender_cost_name'];
                        $bapbSenderCost->price = $cost['price'];
                        $bapbSenderCost->save();

                        $unDeletedCost[] = $bapbSenderCost->bapb_sender_cost_id;
                    }

                    TrBapbSenderItem::where(
                        'bapb_sender_id',
                        $bapbSender->bapb_sender_id
                    )
                        ->whereNotIn(
                            'bapb_sender_item_id',
                            $unDeletedItem
                        )
                        ->delete();

                    TrBapbSenderCost::where(
                        'bapb_sender_id',
                        $bapbSender->bapb_sender_id
                    )
                        ->whereNotIn(
                            'bapb_sender_cost_id',
                            $unDeletedCost
                        )
                        ->delete();
                }

                TrBapbSender::where('bapb_id', $bapb->bapb_id)
                    ->whereNotIn('bapb_sender_id', $unDeletedSender)
                    ->delete();

            }


            DB::commit();
            $response = CoreResponse::ok([
                'bapb_id' => $bapb->bapb_id,
            ]);
        } catch (CoreException $exception) {

            DB::rollBack();
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        try {
            $bapb = TrBapb::findOrFail($id)->delete();
            $response = CoreResponse::ok($bapb);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function verify($id)
    {
        try {
            $bapb = TrBapb::findOrFail($id);
            $bapb->verified = true;
            $bapb->save();

            $response = CoreResponse::ok($bapb);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }


    /**
     * get new bapb_no
     *
     * @param $code
     *
     * @return string
     */
    private function newBapbNo($code)
    {
        $year = Carbon::now()->format('y');
        //        $month = Carbon::now()->format('m');

        $bapb = TrBapb::whereRaw("LEFT(bapb_no, 4) = '$year$code'")
            ->selectRaw('CAST(RIGHT(bapb_no, 5) AS INT) AS bapb_no')
            ->orderBy('bapb_no', 'desc')
            ->first();

        if (! $bapb) {
            return $year . $code . str_pad(1, 6, '0', STR_PAD_LEFT);
        }

        return $year . $code . str_pad($bapb->bapb_no + 1, 6, '0', STR_PAD_LEFT);
    }

    /**
     * @param $bapbId
     *
     * @return array
     */
    public function generatePrint(Request $request, $bapbId)
    {
        try {

            $bapb = TrBapb::findOrFail($bapbId);

            if ($bapb->show_calculation == true) {
                $bapb = TrBapb::with('senders.items')
                    ->with('senders.costs')
                    ->with('senders.sender')
                    ->with('recipient')
                    ->with('ship')
                    ->findOrFail($bapbId);
            } else {
                $bapb = TrBapb::with('senders')
                    ->with('recipient')
                    ->with('ship')
                    ->findOrFail($bapbId);

                $bapb->senders->each(
                    function ($sender) use ($bapb) {

                        $items = DB::select(
                            "
                        SELECT SUM(B.koli) AS koli,
                               STRING_AGG(B.bapb_sender_item_name, ', ') AS bapb_sender_item_name,
                               SUM(B.price) AS price,
                               SUM(B.berat * B.koli) AS berat,
                               round(trunc(((SUM((B.panjang * B.lebar * B.tinggi) * B.koli)) / 1000000::numeric), 4), 3) AS dimensi
                        FROM tr_bapb_sender A
                        INNER JOIN tr_bapb_sender_item B
                            ON A.bapb_sender_id = B.bapb_sender_id
                            AND A.bapb_sender_id = $sender->bapb_sender_id
                            AND B.deleted_at IS NULL
                        WHERE A.deleted_at IS NULL
                    "
                        );

                        foreach ($items as $item_) {
                            $this->berat += ! is_null($item_->berat)
                                ? $item_->berat : 0;
                            $this->dimensi += ! is_null($item_->dimensi)
                                ? $item_->dimensi : 0;
                        }

                        $sender->items = collect($items);
                    }
                );

            }


            $bapb->senders->each(
                function ($sender) use ($bapb) {
                    $sender->terbilang = $this->terbilang($sender->price);

                    $sender->items->each(
                        function ($item) use ($bapb, $sender) {
                            $item->price_ton = (($bapb->tagih_di == 'recipient')
                                ? $bapb->recipient->price_ton : $sender->sender->price_ton);
                            $item->price_meter = (($bapb->tagih_di == 'recipient')
                                ? $bapb->recipient->price_meter
                                : $sender->sender->price_meter);
                        }
                    );
                }
            );

            $bapb->total_price_document = $bapb->recipient->price_document;

            $bapb->total_price = $bapb->senders->reduce(
                function ($i, $j) {
                    return $i + $j->price;
                }
            );

            if ($bapb->tagih_di == 'recipient') {
                $bapb->total_price += $bapb->total_price_document;
                $bapb->terbilang = $this->terbilang($bapb->harga + $bapb->cost);
            } else {
                $bapb->total_price += $bapb->senders[0]->sender->price_document;
                $bapb->terbilang = $this->terbilang(($bapb->harga + $bapb->cost));
            }

            if ($bapb->tagih_di == 'recipient') {
                $bapb->kena_min_charge = ($bapb->total_price != ($bapb->harga + $bapb->cost));
            } else {

                $realPrice = $bapb->senders[0]->items->reduce(
                    function ($i, $j) {
                        return $i + $j->price;
                    }
                );

                $realCost = $bapb->senders[0]->costs->reduce(
                    function ($i, $j) {
                        return $i + $j->price;
                    }
                );

                $bapb->kena_min_charge = ($bapb->total_price != ($realPrice + $realCost));
            }

            if ($bapb->squeeze) {
                $bapb->berat = $this->berat / 1000;
                $bapb->dimensi = $this->dimensi;
            }

            $fullContainer = $bapb->full_container_data;
            if ($bapb->full_container && isset($fullContainer['items'])) {
                foreach ($fullContainer['items'] as $itemIdx => $item) {
                    $fullContainer['items'][$itemIdx]['sender_name'] = MsSender::findOrFail($item['sender_id'])->sender_name_bapb;
                }
            }

            $tipe = $request->input('tipe');
            $data = [
                'tipe'          => $tipe,
                'bapb'          => $bapb,
                'fullContainer' => $fullContainer,
            ];

            $bapbUpdate = TrBapb::findOrFail($bapbId);
            $bapbUpdate->perusahaan = $tipe;
            $bapbUpdate->save();


//            return view('bapb.pdf.print', $data);
            $pdf = PDF::loadView('bapb.pdf.print', $data);

            return $pdf->stream('bapb_' . $bapb->bapb_no . '.pdf');
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     *
     * @param int $code
     *
     * @return array
     */
    public function latestBapb($code = 1)
    {
        try {
            $year = Carbon::now()->format('y');

            $latestBapb = TrBapb::whereNotNull('no_container_1')
                ->whereNotNull('no_container_2')
                ->whereRaw("LEFT(bapb_no, 4) = '$year$code'")
                ->orderBy('created_at', 'desc')
                ->first();

            $response = CoreResponse::ok(compact('latestBapb'));
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param $noVoyage
     *
     * @return mixed
     */
    public function exportExcel($noVoyage, $noContainer)
    {
        return Excel::download(new BapbExport($noVoyage, $noContainer), 'bapb_' . $noVoyage . '-' . $noContainer . '.xlsx');
    }

    /**
     * @param $nilai
     *
     * @return string
     */
    private function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = [
            "",
            "satu",
            "dua",
            "tiga",
            "empat",
            "lima",
            "enam",
            "tujuh",
            "delapan",
            "sembilan",
            "sepuluh",
            "sebelas",
        ];
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut(
                    $nilai % 10
                );
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut(
                    $nilai % 100
                );
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut(
                    $nilai % 1000
                );
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut(
                    $nilai % 1000000
                );
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar"
                . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " trilyun"
                . $this->penyebut(fmod($nilai, 1000000000000));
        }

        return $temp;
    }

    /**
     * @param $nilai
     *
     * @return string
     */
    public function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }

        return $hasil;
    }

    /**
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
    public function container(Request $request)
    {
        $query = "
            SELECT UPPER(CONCAT(A.no_container_1, ' ', A.no_container_2)) as no_container, A.no_seal,
                   UPPER(CONCAT(A.no_container_1, A.no_container_2)) as _no_container,
                   B.no_voyage, B.ship_name, to_char(B.sailing_date, 'dd FMMonth yyyy') as sailing_date,
                   CONCAT(C.city_code, ' - ', C.city_name) as destination,
                   COUNT(A.bapb_id) total,
                   to_char(MAX(D.entry_date), 'dd FMMonth yyyy') as last_entry
            FROM tr_bapb A
            INNER JOIN ms_ship B
             ON A.ship_id = B.ship_id
             AND B.deleted_at IS NULL
            INNER JOIN ms_city C
              ON B.city_id_to = C.city_id
              AND C.deleted_at IS NULL
            LEFT JOIN tr_bapb_sender D
              ON A.bapb_id = D.bapb_id
              AND D.deleted_at IS NULL
            WHERE A.deleted_at IS NULL
            GROUP BY no_container, _no_container, A.no_seal, B.no_voyage, B.ship_name, B.sailing_date, destination
        ";

        return DataTables::of(DB::TABLE(DB::RAW("(" . $query . ") AS X")))->make();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function paymentList(Request $request)
    {
        try {
            $shipId = $request->input('ship_id');
            $containers = $request->input('containers');

            if (collect($containers)->isEmpty()) {
                $bapbList = [];

                return CoreResponse::ok(compact('bapbList'));
            }


            $containers = collect($containers)
                ->map(
                    function ($container) {
                        return preg_replace('/\s+/', '', strtoupper($container));
                    }
                )
                ->implode("', '");


            $bapbList = DB::select(
                "
                SELECT A.bapb_id, A.bapb_no,
                       A.koli,
                       COALESCE(A.harga,0) + COALESCE(A.cost,0) AS total,
                       CAST(A.payment_total AS INT) AS payment_total,
                       to_char(A.payment_date, 'dd-mm-yyyy') as payment_date,
                       A.is_paid,
                       B.recipient_name_bapb,
                       FALSE as is_input,
                       A.potongan
                FROM tr_bapb A
                INNER JOIN ms_recipient B
                    ON A.recipient_id = B.recipient_id
                    AND B.deleted_at IS NULL
                WHERE A.deleted_at IS NULL
                AND A.ship_id = $shipId
                AND REPLACE(UPPER(CONCAT(A.no_container_1, A.no_container_2)), ' ', '') IN ('$containers')
                ORDER BY A.created_at DESC
            "
            );


            $response = CoreResponse::ok(compact('bapbList'));
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function paymentSave(Request $request)
    {
        try {

            $bapb = TrBapb::findOrFail($request->input('bapb_id'));

            $bapb->payment_total = $request->input('payment_total');
            $bapb->potongan = $request->input('potongan');
            $bapb->payment_date = Carbon::parse(
                $request->input('payment_date')
            );
            $bapb->save();

            $response = CoreResponse::ok([]);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
    public function ppn(Request $request)
    {
        $query = "
SELECT ms_recipient.recipient_name_bapb                                   AS customer,
       tr_invoice.invoice_no,
       ms_ship.no_voyage,
       tr_bapb.bapb_no,
       UPPER(CONCAT(tr_bapb.no_container_1, ' ', tr_bapb.no_container_2)) as no_container,
       tr_bapb.harga                                                      AS dpp,
       CASE
           WHEN tr_pajak.date is null
           THEN  round(tr_bapb.harga * 0.01)
           ELSE  round(tr_bapb.harga * tr_pajak.ppn / 100)
       END AS ppn,
        CASE
           WHEN tr_pajak.date is null
           THEN tr_bapb.harga + round(tr_bapb.harga * 0.01)
           ELSE tr_bapb.harga + round(tr_bapb.harga * tr_pajak.ppn / 100)
       END AS final
FROM tr_bapb
         INNER JOIN ms_ship
                    ON tr_bapb.ship_id = ms_ship.ship_id
                        AND ms_ship.deleted_at IS NULL
         JOIN tr_invoice_bapb
              ON tr_bapb.bapb_id = tr_invoice_bapb.bapb_id
                  AND tr_invoice_bapb.deleted_at IS NULL
         JOIN tr_invoice
              ON tr_invoice_bapb.invoice_id = tr_invoice.invoice_id
                  AND tr_invoice.deleted_at IS NULL
         JOIN ms_recipient
              ON tr_bapb.recipient_id = ms_recipient.recipient_id
                  AND ms_recipient.deleted_at IS NULL
         LEFT JOIN tr_pajak
              ON tr_bapb.created_at::DATE = tr_pajak.date
WHERE tr_bapb.deleted_at IS NULL
        ";

        return DataTables::of(DB::TABLE(DB::RAW("(" . $query . ") AS X")))->make();
    }
}
