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
use App\TrBapbSenderCost;
use Barryvdh\DomPDF\Facade as PDF;
use App\TrBapb;
use App\TrBapbSender;
use App\TrBapbSenderItem;
use Carbon\Carbon;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class BapbController extends Controller
{
    /**
     * get new bapb no
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
          SELECT A.bapb_id, A.bapb_no, CONCAT(A.no_container_1, ' ', A.no_container_2) as no_container, A.no_seal,
              B.no_voyage, C.recipient_name_bapb, string_agg(D.no_ttb, ', ') as no_ttb,
              COALESCE(A.harga,0) + COALESCE(A.cost,0) AS total
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
            WHERE A.deleted_at IS NULL
            GROUP BY A.bapb_id, A.bapb_no, no_container, no_seal, no_voyage, recipient_name_bapb,
                     A.harga, A.berat
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
                $sender->detail = MsSender::with('city')->find($sender->sender_id);
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
            $bapb->ship_id = $request->input('ship_id');
            $bapb->recipient_id = $request->input('recipient_id');
            $bapb->show_calculation = $request->input('show_calculation');

            $total = $request->input('total');
            $bapb->harga = isset($total['harga']) ? $total['harga'] : 0;
            $bapb->cost = isset($total['cost']) ? $total['cost'] : 0;
            $bapb->dimensi = isset($total['dimensi']) ? $total['dimensi'] : 0;
            $bapb->berat = isset($total['berat']) ? $total['berat'] : 0;
            $bapb->koli = isset($total['koli']) ? $total['koli'] : 0;

            $bapb->save();

            $unDeletedSender = [];
            $unDeletedItem = [];
            $unDeletedCost = [];
            foreach ($request->input('senders') as $sender) {
                if (isset($sender['bapb_sender_id'])) {
                    $bapbSender = TrBapbSender::findOrFail($sender['bapb_sender_id']);
                } else {
                    $bapbSender = new TrBapbSender();
                }
                $bapbSender->bapb_id = $bapb->bapb_id;
                $bapbSender->sender_id = $sender['sender_id'];
                $bapbSender->kemasan = isset($sender['kemasan']) ? $sender['kemasan'] : NULL;
                $bapbSender->krani = isset($sender['krani']) ? $sender['krani'] : NULL;
                $bapbSender->no_ttb = isset($sender['no_ttb']) ? $sender['no_ttb'] : NULL;
                $bapbSender->description = isset($sender['description']) ? $sender['description'] : NULL;
                $bapbSender->entry_date = isset($sender['entry_date']) ? Carbon::parse($sender['entry_date']) : NULL;
                $bapbSender->price = isset($sender['total_price']) ? $sender['total_price'] : 0;
                $bapbSender->save();

                $unDeletedSender[] = $bapbSender->bapb_sender_id;
                foreach ($sender['items'] as $item) {
                    if (isset($item['bapb_sender_item_id'])) {
                        $bapbSenderItem = TrBapbSenderItem::findOrFail($item['bapb_sender_item_id']);
                    } else {
                        $bapbSenderItem = new TrBapbSenderItem();
                    }
                    $bapbSenderItem->bapb_sender_id = $bapbSender->bapb_sender_id;
                    $bapbSenderItem->bapb_sender_item_name = $item['bapb_sender_item_name'];
                    $bapbSenderItem->koli = $item['koli'];
                    $bapbSenderItem->panjang = $item['panjang'];
                    $bapbSenderItem->lebar = $item['lebar'];
                    $bapbSenderItem->tinggi = $item['tinggi'];
                    $bapbSenderItem->berat = $item['berat'];
                    $bapbSenderItem->price = isset($item['price']) ? $item['price'] : 0;
                    $bapbSenderItem->save();

                    $unDeletedItem[] = $bapbSenderItem->bapb_sender_item_id;
                }

                foreach ($sender['costs'] as $cost) {
                    if (isset($cost['bapb_sender_cost_id'])) {
                        $bapbSenderCost = TrBapbSenderCost::findOrFail($cost['bapb_sender_cost_id']);
                    } else {
                        $bapbSenderCost = new TrBapbSenderCost();
                    }
                    $bapbSenderCost->bapb_sender_id = $bapbSender->bapb_sender_id;
                    $bapbSenderCost->bapb_sender_cost_name = $cost['bapb_sender_cost_name'];
                    $bapbSenderCost->price = $cost['price'];
                    $bapbSenderCost->save();

                    $unDeletedCost[] = $bapbSenderCost->bapb_sender_cost_id;
                }

                TrBapbSenderItem::where('bapb_sender_id', $bapbSender->bapb_sender_id)
                    ->whereNotIn('bapb_sender_item_id', $unDeletedItem)
                    ->delete();

                TrBapbSenderCost::where('bapb_sender_id', $bapbSender->bapb_sender_id)
                    ->whereNotIn('bapb_sender_cost_id', $unDeletedCost)
                    ->delete();
            }

            TrBapbSender::where('bapb_id', $bapb->bapb_id)
                ->whereNotIn('bapb_sender_id', $unDeletedSender)
                ->delete();

            DB::commit();
            $response = CoreResponse::ok();
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
            $bapb->verified = TRUE;
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

        $bapb = TrBapb::whereRaw("LEFT(bapb_no, 3) = '$year$code'")
            ->selectRaw('CAST(RIGHT(bapb_no, 6) AS INT) AS bapb_no')
            ->orderBy('bapb_no', 'desc')
            ->first();

        if (!$bapb) {
            return $year . $code . str_pad(1, 7, '0', STR_PAD_LEFT);
        }

        return $year . $code . str_pad($bapb->bapb_no + 1, 7, '0', STR_PAD_LEFT);
    }

    /**
     * @param $bapbId
     *
     * @return array
     */
    public function generatePrint($bapbId)
    {
        try {
            $bapb = TrBapb::with('senders.items')
                ->with('senders.costs')
                ->with('senders.sender')
                ->with('recipient')
                ->with('ship')
                ->findOrFail($bapbId);

            $bapb->senders->each(function ($sender) use ($bapb) {
                $sender->terbilang = $this->terbilang($sender->price);

                $sender->items->each(function ($item) use ($bapb, $sender) {
                    $item->price_ton = (($bapb->tagih_di == 'recipient') ? $bapb->recipient->price_ton : $sender->price_ton);
                    $item->price_meter = (($bapb->tagih_di == 'recipient') ? $bapb->recipient->price_meter : $sender->price_meter);
                });
            });

            $bapb->total_price_document = $bapb->recipient->price_document;

            $bapb->total_price = $bapb->senders->reduce(function ($i, $j) {
               return $i + $j->price;
            });

            $bapb->total_price += $bapb->total_price_document;

            $bapb->terbilang = $this->terbilang($bapb->harga);

            $bapb->kena_min_charge = $bapb->tagih_di == 'recipient' && $bapb->total_price != ($bapb->harga + $bapb->cost);


            $data = [
                'bapb' => $bapb,
            ];

            $pdf = PDF::loadView('bapb.pdf.print', $data);
            return $pdf->stream('bapb.pdf');
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     *
     * @param int $code
     * @return array
     */
    public function latestBapb($code = 1)
    {
        try {
            $year = Carbon::now()->format('y');

            $latestBapb = TrBapb::whereNotNull('no_container_1')
                ->whereNotNull('no_container_2')
                ->whereRaw("LEFT(bapb_no, 3) = '$year$code'")
                ->orderBy('created_at', 'desc')
                ->first();

            $response = CoreResponse::ok(compact('latestBapb'));
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param $noContainer
     * @return mixed
     */
    public function exportExcel($noContainer)
    {
        return Excel::download(new BapbExport($noContainer), 'users.xlsx');
    }

    /**
     * @param $nilai
     * @return string
     */
    private function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    /**
     * @param $nilai
     * @return string
     */
    private function terbilang($nilai)
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
}
