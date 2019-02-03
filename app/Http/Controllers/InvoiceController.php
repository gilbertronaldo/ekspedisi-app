<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 1/29/19
 * Time: 1:38 AM
 */

namespace App\Http\Controllers;


use App\TrBapb;
use App\TrInvoice;
use App\TrInvoiceBapb;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{

    /**
     * get new bapb no
     *
     * @return array
     */
    public function no()
    {
        try {
            $bapbNo   = $this->newInvoiceNo();
            $response = CoreResponse::ok($bapbNo);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * get new bapb_no
     *
     * @return string
     */
    private function newInvoiceNo()
    {
        $year  = Carbon::now()->format('y');
        $month = Carbon::now()->format('m');

        $invoice = TrInvoice::whereRaw("LEFT(invoice_no, 4) = '$year$month'")
                            ->selectRaw(
                              'CAST(RIGHT(invoice_no, 5) AS INT) AS invoice_no'
                            )
                            ->orderBy('invoice_no', 'desc')
                            ->first();

        if ( ! $invoice) {
            return $year.$month.str_pad(1, 6, '0', STR_PAD_LEFT);
        }

        return $year.$month.str_pad(
            $invoice->invoice_no + 1,
            6,
            '0',
            STR_PAD_LEFT
          );
    }

    /**
     * get new bapb list
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function bapbList(Request $request)
    {
        try {
            $recipientId = $request->input('recipient_id');

            $get = DB::select(
              "
                 SELECT A.bapb_id, A.bapb_no, CONCAT(A.no_container_1, ' ', A.no_container_2) as no_container, A.no_seal,
                  B.no_voyage, C.recipient_name_bapb, string_agg(D.no_ttb, ', ') as no_ttb,
                  COALESCE(A.harga,0) + COALESCE(A.cost,0) AS total, E.city_code, 
                  to_char(B.sailing_date, 'dd FMMonth yyyy') as sailing_date
                FROM tr_bapb A
                INNER JOIN ms_ship B
                  ON A.ship_id = B.ship_id
                  AND B.deleted_at IS NULL
                INNER JOIN ms_recipient C 
                  ON A.recipient_id = C.recipient_id
                  AND C.deleted_at IS NULL
                INNER JOIN ms_city E 
                  ON B.city_id_to = E.city_id
                LEFT JOIN tr_bapb_sender D 
                  ON A.bapb_id = D.bapb_id
                  AND D.deleted_at IS NULL
                WHERE A.deleted_at IS NULL
                --AND A.recipient_id = $recipientId
                GROUP BY A.bapb_id, A.bapb_no, no_container, no_seal, no_voyage, recipient_name_bapb,
                         A.harga, A.berat, E.city_code, B.sailing_date
            "
            );

            $bapbList = $get;
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
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->has('invoice_id')) {
                $invoice = TrInvoice::findOrFail($request->input('invoice_id'));
            } else {
                $invoice             = new TrInvoice();
                $invoice->invoice_no = $request->input('invoice_no');
            }

            $invoice->save();

            $bapbList = $request->input('bapb_list');
            foreach ($bapbList as $bapbId) {
                $bapb = new TrInvoiceBapb();
                $bapb->setInvoice($invoice);
                $bapb->setBapb(TrBapb::findOrFail($bapbId));
                $bapb->save();
            }

            DB::commit();
            $response = CoreResponse::ok();
        } catch (CoreException $exception) {

            DB::rollBack();
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param $invoiceId
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePrint($invoiceId)
    {
        $invoice = TrInvoice::findOrFail($invoiceId);

        $bapb = DB::select(
          "
          SELECT A.invoice_id, A.invoice_no,
                 C.bapb_id, C.bapb_no,
                 COALESCE(C.harga,0) + COALESCE(C.cost,0) AS total,
                 UPPER(CONCAT(C.no_container_1, ' ', C.no_container_2)) as no_container,
                 CONCAT(E.city_code) as destination,
                 to_char(D.sailing_date, 'dd/mm/yyyy') as sailing_date,
                 JSON_AGG(DISTINCT G.sender_name_bapb) AS senders
          FROM tr_invoice A 
          INNER JOIN tr_invoice_bapb B
            ON A.invoice_id = B.invoice_id
            AND B.deleted_at IS NULL
          INNER JOIN tr_bapb C
            ON B.bapb_id = C.bapb_id 
            AND C.deleted_at IS NULL
          INNER JOIN ms_ship D 
            ON C.ship_id = D.ship_id
          INNER JOIN ms_city E
            ON D.city_id_to = E.city_id
          LEFT JOIN tr_bapb_sender F 
            ON C.bapb_id = F.bapb_id
            AND F.deleted_at IS NULL
          LEFT JOIN ms_sender G
            ON F.sender_id = G.sender_id
            AND G.deleted_at IS NULL
          WHERE A.deleted_at IS NULL
          GROUP BY A.invoice_id, A.invoice_no, C.bapb_id, C.bapb_no, C.harga, C.cost,
                   C.no_container_1, C.no_container_2,
                   E.city_code, E.city_name,
                   D.sailing_date
        "
        );

        collect($bapb)->each(
          function ($i)
          {
              $i->senders = implode(", ", json_decode($i->senders));
          }
        );

        $input = [
          'invoice'  => $invoice,
          'bapbList' => $bapb,
        ];

        $pdf = PDF::loadView('invoice.pdf.print', $input);

        return $pdf->stream('invoice.pdf');
    }
}
