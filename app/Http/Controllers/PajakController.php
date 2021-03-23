<?php

namespace App\Http\Controllers;

use App\TrPajak;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class PajakController
 *
 * @package App\Http\Controllers
 */
class PajakController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|array[]
     */
    public function save(Request $request)
    {
        try {
            DB::beginTransaction();

            $input = [
                'date_start' => (new Carbon($request->input('date_start')))->toDateString(),
                'date_end'   => (new Carbon($request->input('date_end')))->toDateString(),
                'ppn'        => $request->input('ppn'),
                'pph_23'     => $request->input('pph_23'),
            ];

            $dateRange = CarbonPeriod::create($input['date_start'], $input['date_end']);
            foreach ($dateRange as $date) {
                $dates[] = $date->toDateString();

                $pajak = TrPajak::firstOrNew([
                    'date' => $date->toDateString(),
                ]);
                $pajak->ppn = $input['ppn'];
                $pajak->pph_23 = $input['pph_23'];
                $pajak->save();
            }

            $pajak = null;

            $response = CoreResponse::ok([
                'pajak' => $pajak,
            ]);
            DB::commit();
        } catch (CoreException $e) {
            DB::rollBack();
            $response = CoreResponse::fail($e);
        }

        return $response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|array[]
     */
    public function list(Request $request)
    {
        try {

            $dates = TrPajak::query()
                ->orderBy('date')
                ->get()
                ->toArray();

            $rangesPpn = [];
            $rangesPph23 = [];

            foreach ($dates as $date) {
                if (empty($rangesPpn)) {
                    $rangesPpn[] = [
                        'date_start' => $date['date'],
                        'date_end'   => $date['date'],
                        'ppn'        => $date['ppn'],
                    ];
                    continue;
                }
                $rangesLastIdx = count($rangesPpn) - 1;
                $last = $rangesPpn[$rangesLastIdx];
                if ($last['ppn'] === $date['ppn']) {
                    $rangesPpn[$rangesLastIdx]['date_end'] = $date['date'];
                } else {
                    $rangesPpn[] = [
                        'date_start' => $date['date'],
                        'date_end'   => $date['date'],
                        'ppn'     => $date['ppn'],
                    ];
                }
            }

            foreach ($dates as $date) {
                if (empty($rangesPph23)) {
                    $rangesPph23[] = [
                        'date_start' => $date['date'],
                        'date_end'   => $date['date'],
                        'pph_23'     => $date['pph_23'],
                    ];
                    continue;
                }
                $rangesLastIdx = count($rangesPph23) - 1;
                $last = $rangesPph23[$rangesLastIdx];
                if ($last['pph_23'] === $date['pph_23']) {
                    $rangesPph23[$rangesLastIdx]['date_end'] = $date['date'];
                } else {
                    $rangesPph23[] = [
                        'date_start' => $date['date'],
                        'date_end'   => $date['date'],
                        'pph_23'     => $date['pph_23'],
                    ];
                }
            }

            $response = CoreResponse::ok([
                'ppn'    => $rangesPpn,
                'pph_23' => $rangesPph23,
            ]);
        } catch (CoreException $e) {
            $response = CoreResponse::fail($e);
        }

        return $response;
    }
}
