<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 1/29/19
 * Time: 1:38 AM
 */

namespace App\Http\Controllers;


use App\Exports\InvoiceExport;
use App\MsOfficeBranch;
use App\MsRecipient;
use App\MsSender;
use App\TrBapb;
use App\TrInvoice;
use App\TrInvoiceBapb;
use App\TrPajak;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
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
            $bapbNo = $this->newInvoiceNo();
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
            $bapbNo = DB::select("
                SELECT last_value FROM tr_invoice_invoice_id_seq;
            ");
            $response = CoreResponse::ok($bapbNo[0]->last_value + 1);
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
        $year = Carbon::now()->format('y');
        $month = Carbon::now()->format('m');

        # CODE UNTUK INVOICE, FIX
        $month = '06';

        $invoice = TrInvoice::whereRaw("LEFT(invoice_no, 4) = '$year$month'")
            ->selectRaw(
                'CAST(RIGHT(invoice_no, 5) AS INT) AS invoice_no'
            )
            ->orderBy('invoice_no', 'desc')
            ->first();

        if (! $invoice) {
            return $year . $month . str_pad(1, 6, '0', STR_PAD_LEFT);
        }

        return $year . $month . str_pad(
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
                AND A.recipient_id = $recipientId
                AND A.verified IS TRUE
                AND A.bapb_id NOT IN (
                  SELECT X.bapb_id
                  FROM tr_invoice_bapb X
                  WHERE X.deleted_at IS NULL
                )
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
                $invoice = new TrInvoice();
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
            $response = CoreResponse::ok([
                'invoice_id' => $invoice->invoice_id,
            ]);
        } catch (CoreException $exception) {

            DB::rollBack();
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $invoiceId
     *
     * @return \Illuminate\Http\Response|string
     * @throws \Exception
     */
    public function generatePrint(Request $request, $invoiceId)
    {
        MsOfficeBranch::createData();

        try {
            DB::beginTransaction();

            $invoice = TrInvoice::findOrFail($invoiceId);
            $invoice->pajak = $request->input('pajak');
            $invoice->is_pph = $request->input('pph') === 'true';
            $invoice->save();

            $invoice->tgl = Carbon::parse($invoice->created_at)->format('d/m/Y');

            $bapb = DB::select(
                "
          SELECT A.invoice_id, A.invoice_no, A.is_pph,
                 C.bapb_id, C.bapb_no, C.tagih_di, H.recipient_id, H.recipient_name_bapb,
                 COALESCE(C.harga,0) AS harga,
                 COALESCE(C.cost,0) AS cost,
                 H.price_document,
                 UPPER(C.no_container_2) as no_container,
                 CONCAT(E.city_code) as destination,
                 to_char(D.sailing_date, 'dd/mm/yyyy') as sailing_date,
                 json_agg(DISTINCT G.sender_id) AS sender_ids,
                 JSON_AGG(DISTINCT G.sender_name_bapb) AS senders,
                 case when count(I) = 0
                     then '[]'
                     else JSON_AGG(json_build_object('id', I.bapb_sender_cost_id,
                         'sender', G.sender_name,
                         'name', I.bapb_sender_cost_name, 'price', I.price))
                 end as costs
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
          LEFT JOIN tr_bapb_sender_cost I
            ON I.bapb_sender_id = F.bapb_sender_id
            AND I.price IS NOT NULL
            AND I.deleted_at IS NULL
          INNER JOIN ms_recipient H
            ON C.recipient_id = H.recipient_id
            AND H.deleted_at IS NULL
          WHERE A.deleted_at IS NULL
          AND A.invoice_id = $invoiceId
          GROUP BY A.invoice_id, A.invoice_no, C.bapb_id, C.bapb_no, C.harga, C.cost,
                   C.no_container_1, C.no_container_2,
                   E.city_code, E.city_name,
                   D.sailing_date,
                   H.recipient_id, H.recipient_name_bapb
        "
            );

            $recipient = null;
            if (! empty($bapb)) {
                $recipient = MsRecipient::with('city')->findOrFail(
                    $bapb[0]->recipient_id
                );
            }

            $sender = null;
            if (! empty($bapb)) {
                $senderIds = json_decode($bapb[0]->sender_ids);
                if (!empty($senderIds)) {
                    $sender = MsSender::with('city')->findOrFail(
                        $senderIds[0]
                    );
                }
            }

            if (is_null($recipient)) {
                return 'no recipient';
            }

            $cityCodeRecipient = $recipient->city->city_code;

            $officeBranch = MsOfficeBranch::whereCityCode($cityCodeRecipient, $invoice->is_pph);

            collect($bapb)->each(
                function ($i) {
                    $i->senders = implode(", ", json_decode($i->senders));
                    $i->costs = json_decode($i->costs);

//                    if ($i->tagih_di != 'recipient') {
//                        $i->harga += $i->price_document;
//                    }
                }
            );

            $subTotal = collect($bapb)->reduce(
                function ($i, $j) {
                    return $i + $j->harga;
                }
            );

            $costTotal = collect($bapb)->reduce(
                function ($i, $j) {
                    return $i + $j->cost;
                }
            );

            $pph23 = 0;
            $pph = 0;
            if ($invoice->is_pph === true) {
                $pajak = TrPajak::query()
                    ->where('date', '=', $invoice->created_at->toDateString())
                    ->first();

                if ($pajak) {
                    $pph23 = $pajak->pph_23;
                } else {
                    $pph23 = 2;
                }

                $pph = round($subTotal * $pph23 / 100, 0);
            }

            $totalAll = $subTotal - $pph + $costTotal;

            $input = [
                'invoice'      => $invoice,
                'bapbList'     => $bapb,
                'subTotal'     => $subTotal,
                'totalPph'     => $pph,
                'totalAll'     => $totalAll,
                'recipient'    => $recipient,
                'sender'       => $sender,
                'officeBranch' => $officeBranch,
                'pph23'        => $pph23,
            ];

            DB::commit();

//            return view('invoice.pdf.print', $input);
            $pdf = PDF::loadView('invoice.pdf.print', $input);

            return $pdf->stream('invoice_' . $invoice->invoice_no . '.pdf');

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param $invoiceId
     *
     * @return \Illuminate\Http\Response
     */
    public function generateKwitansi(Request $request, $invoiceId)
    {
        $invoice = TrInvoice::findOrFail($invoiceId);

        $pajak = $request->input('pajak');

        $bapb = DB::select(
            "
          SELECT A.invoice_id, A.invoice_no, C.tagih_di,
                 C.bapb_id, C.bapb_no, H.recipient_id, G.sender_id,
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
          INNER JOIN ms_recipient H
            ON C.recipient_id = H.recipient_id
            AND H.deleted_at IS NULL
          WHERE A.deleted_at IS NULL
          AND A.invoice_id = $invoiceId
          GROUP BY A.invoice_id, A.invoice_no, C.bapb_id, C.bapb_no, C.harga, C.cost, C.tagih_di,
                   C.no_container_1, C.no_container_2,
                   E.city_code, E.city_name,
                   D.sailing_date,
                   H.recipient_id, G.sender_id
        "
        );

        $recipient = null;
        if (! empty($bapb)) {
            $recipient = MsRecipient::with('city')->findOrFail(
                $bapb[0]->recipient_id
            );
        }

        $sender = null;
        if (! empty($bapb)) {
            $sender = MsSender::with('city')->findOrFail(
                $bapb[0]->sender_id
            );
        }

        collect($bapb)->each(
            function ($i) {
                $i->senders = implode(", ", json_decode($i->senders));
            }
        );

        $total = collect($bapb)->reduce(
            function ($i, $j) {
                return $i + $j->total;
            }
        );

        $terbilang = (new BapbController())->terbilang($total);

        $input = [
            'invoice'   => $invoice,
            'bapbList'  => $bapb,
            'total'     => $total,
            'terbilang' => $terbilang,
            'recipient' => $recipient,
            'sender'    => $sender,
            'pajak'     => $pajak,
        ];

        $pdf = PDF::loadView('invoice.kwitansi.print', $input);

        return $pdf->stream('kwitansi_' . $invoice->invoice_no . '.pdf');
    }

    /**
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
    public function all(Request $request, $paid = 'false')
    {
        $user = auth()->user();

        if ($paid === 'true') {
            $paid = 'AND CC.payment_date IS NOT NULL';
        } else {
            $paid = 'AND CC.payment_date IS NULL';
        }

        $param = $request->all();
        if (isset($param['search'], $param['search']['value']) && $param['search']['value'] !== null && $param['search']['value'] !== '') {
            $paid = '';
        }

        // INVOICE SEARCH HANYA BOLEH SUPERADMIN SAJA
        $limit = '';
        if ($paid === '') {
            if ($user->id !== 1) {
//                $limit = 'LIMIT 0';
                $paid = 'AND CC.payment_date IS NULL';
            }
        }

        $query = "
         SELECT AA.invoice_id, AA.invoice_no, AA.recipient_name_bapb, AA.creator,
               string_agg(DISTINCT CC.bapb_no, ', ') AS bapb_no,
               string_agg(DD.no_voyage, ', ') AS no_voyage,
               cc.payment_date
            FROM (
                   SELECT A.invoice_id, A.invoice_no,
                          D.recipient_name_bapb, G.name AS creator
                   FROM tr_invoice A
                          INNER JOIN tr_invoice_bapb B
                                     ON A.invoice_id = B.invoice_id
                                       AND B.deleted_at IS NULL
                          INNER JOIN tr_bapb C
                                     ON B.bapb_id = C.bapb_id
                                       AND C.deleted_at IS NULL
                          INNER JOIN ms_recipient D
                                     ON C.recipient_id = D.recipient_id
                                       AND D.deleted_at IS NULL
                           LEFT JOIN audits F
                                ON F.auditable_id = A.invoice_id
                                AND F.auditable_type = 'App\TrInvoice'
                                AND F.event = 'created'
                            LEFT JOIN users G
                                ON G.id = F.user_id
                   WHERE A.deleted_at IS NULL
                   GROUP BY A.invoice_id, A.invoice_no, D.recipient_name_bapb, G.name
             ) AA
            INNER JOIN tr_invoice_bapb BB
                ON AA.invoice_id = BB.invoice_id
                AND BB.deleted_at IS NULL
            INNER JOIN tr_bapb CC
                ON BB.bapb_id = CC.bapb_id
                AND CC.deleted_at IS NULL
                $paid
            INNER JOIN ms_ship DD
                ON CC.ship_id = DD.ship_id
                AND DD.deleted_at IS NULL
            GROUP BY AA.invoice_id, AA.invoice_no, AA.recipient_name_bapb, AA.creator, CC.payment_date
            $limit
        ";

        return DataTables::of(DB::TABLE(DB::RAW("(" . $query . ") AS X")))->make();
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        try {

            $bapb = TrInvoice::findOrFail($id)->delete();
            $response = CoreResponse::ok($bapb);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param $invoiceId
     *
     * @return mixed
     */
    public function exportExcel($invoiceId)
    {
        $invoice = TrInvoice::findOrFail($invoiceId);

        return Excel::download(new InvoiceExport($invoiceId), 'invoice_' . $invoice->invoice_no . '.xlsx');
    }

}
