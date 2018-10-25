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
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use App\TrBapb;
use App\TrBapbSender;
use App\TrBapbSenderItem;
use Carbon\Carbon;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BapbController
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
     * @return array
     * @throws \Exception
     */
    public function all(Request $request)
    {
        $bapbList = TrBapb::with('senders.items')
            ->with('recipient')
            ->with('ship')
            ->get();

        $bapbList->each(function ($i) {
            $i->no_container = $i->no_container_1 . " " . $i->no_container_2;
        });

        return datatables()->of($bapbList)->toJson();
    }

    /**
     * @param $id
     * @return array
     */
    public function get($id)
    {
        try {
            $bapb = TrBapb::with('senders.items')
                ->findOrFail($id);
            foreach ($bapb->senders as $sender) {
                $sender->detail = MsSender::find($sender->sender_id);
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
            $bapb->save();

            $unDeletedSender = [];
            $unDeletedItem = [];
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
                $bapbSender->entry_date = isset($sender['entry_date']) ? Carbon::parse($sender['entry_date']) : NULL;
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
                    $bapbSenderItem->save();

                    $unDeletedItem[] = $bapbSenderItem->bapb_sender_item_id;
                }
            }

            TrBapbSenderItem::whereNotIn('bapb_sender_item_id', $unDeletedItem)->delete();
            TrBapbSender::whereNotIn('bapb_sender_id', $unDeletedSender)->delete();

            DB::commit();
            $response = CoreResponse::ok();
        } catch (CoreException $exception) {

            DB::rollBack();
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

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
     * get new bapb_no
     * @param $code
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
                ->findOrFail($bapbId);
            if (!empty($bapb->senders)) {
                foreach ($bapb->senders as $sender) {
                    $sender->detail = MsSender::find($sender->sender_id);
                }
            }

            $data = [
                'bapb' => $bapb
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
     * @return mixed
     */
    public function exportExcel()
    {
        return Excel::download(new BapbExport(), 'users.xlsx');
    }
}
