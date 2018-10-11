<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/31/18
 * Time: 11:36 PM
 */

namespace App\Http\Controllers;

use App\MsRecipient;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RecipientController
{

    public function all(Request $request)
    {
        $query = MsRecipient::get();
        foreach ($query as $q) {
            $q->city_name = '';
            if ($q->city) {
                $q->city_name = $q->city->city_name;
            }
        }
        return datatables()->of($query)->toJson();
    }

    public function get($id)
    {
        try {
            $data = MsRecipient::with('city')->findOrFail($id);
            $data->city_name = '';
            if ($data->city) {
                $data->city_name = $data->city->city_name;
            }
            $response = CoreResponse::ok($data);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function search(Request $request)
    {
        try {
            $text = (string)$request->input('text');
            $page = (int)$request->input('page') || 0;
            $limit = (int)$request->input('limit') || 10;

            $recipientList = MsRecipient::where('recipient_name', 'ilike', "%$text%")
                ->orWhere('recipient_code', 'ilike', "%$text%")
                ->leftjoin('ms_city', 'ms_city.city_id', '=', 'ms_recipient.city_id')
                ->offset($page - 1)
                ->limit($limit)
                ->get();
            $count = MsRecipient::where('recipient_name', 'ilike', "%$text%")
                ->orWhere('recipient_code', 'ilike', "%$text%")
                ->count();
            $response = CoreResponse::ok(compact('recipientList', 'count'));
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function store(Request $request)
    {
        try {
            if ($request->has('recipient_id')) {
                $data = MsRecipient::findOrFail($request->input('recipient_id'));
            } else {
                $data = new MsRecipient();
            }

            $data->recipient_code = $request->input('recipient_code');
            $data->recipient_name = $request->input('recipient_name');
            $data->recipient_name_bapb = $request->input('recipient_name_bapb');
            $data->recipient_name_other = $request->input('recipient_name_other');
            $data->recipient_phone = $request->input('recipient_phone');
            $data->recipient_telephone = $request->input('recipient_telephone');
            $data->recipient_fax = $request->input('recipient_fax');
            $data->recipient_address = $request->input('recipient_address');
            $data->city_id = $request->input('city_id');
            $data->price_ton = $request->input('price_ton');
            $data->price_meter = $request->input('price_meter');
            $data->price_document = $request->input('price_document');
            $data->minimum_charge = $request->input('minimum_charge');
            $data->minimum_charge_calculation_id = $request->input('minimum_charge_calculation_id');
            $data->ambil_di = $request->input('ambil_di');
            $data->save();
            $response = CoreResponse::ok();
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function destroy($id)
    {
        try {
            MsRecipient::findOrFail($id)->delete();
            $response = CoreResponse::ok();
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}
