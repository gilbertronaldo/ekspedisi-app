<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/31/18
 * Time: 11:36 PM
 */

namespace App\Http\Controllers;

use DB;
use App\TrBapb;
use App\TrBapbSender;
use App\TrBapbSenderItem;
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
            $bapbList = TrBapb::with('senders.items')->get();
            $response = CoreResponse::ok($bapbList);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $bapb = new TrBapb();
            $bapb->bapb_no = $this->newBapbNo();
            $bapb->bapb_description = $request->input('bapb_description');
            $bapb->ship_id = $request->input('ship_id');
            $bapb->recipient_id = $request->input('recipient_id');
            $bapb->save();

            foreach ($request->input('senders') as $sender) {
                $bapbSender = new TrBapbSender();
                $bapbSender->bapb_id = $bapb->bapb_id;
                $bapbSender->sender_id = $sender['sender_id'];
                $bapbSender->save();

                foreach ($sender['items'] as $item) {
                    $bapbSenderItem = new TrBapbSenderItem();
                    $bapbSenderItem->bapb_sender_id = $bapbSender->bapb_sender_id;
                    $bapbSenderItem->bapb_sender_item_name = $item['bapb_sender_item_name'];
                    $bapbSenderItem->koli = $item['koli'];
                    $bapbSenderItem->panjang = $item['panjang'];
                    $bapbSenderItem->lebar = $item['lebar'];
                    $bapbSenderItem->tinggi = $item['tinggi'];
                    $bapbSenderItem->berat = $item['berat'];
                    $bapbSenderItem->save();
                }
            }

            DB::commit();
            $response = CoreResponse::ok();
        } catch (CoreException $exception) {

            DB::rollBack();
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
    private function newBapbNo()
    {
        $year = Carbon::now()->format('y');

        $bapb = TrBapb::whereRaw("LEFT(bapb_no, 2) = '$year'")
            ->selectRaw('CAST(RIGHT(bapb_no, 8) AS INT) AS bapb_no')
            ->orderBy('bapb_no', 'desc')
            ->first();

        if (!$bapb) {
            return $year . str_pad(1, 8, '0', STR_PAD_LEFT);
        }

        return $year . str_pad($bapb->bapb_no + 1, 8, '0', STR_PAD_LEFT);
    }
}
