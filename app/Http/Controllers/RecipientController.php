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
            $q->city_name = $q->city->city_name;
        }
        return datatables()->of($query)->toJson();
    }

    public function get($id)
    {
        try {
            $data = MsRecipient::findOrFail($id);
            $response = CoreResponse::ok($data);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function store(Request $request)
    {
        try {
            if ($request->has('recipient_id')) {
                $ship = MsRecipient::findOrFail($request->input('recipient_id'));
            } else {
                $ship = new MsRecipient();
            }

            $ship->recipient_code = $request->input('recipient_code');
            $ship->recipient_name = $request->input('recipient_name');
            $ship->recipient_name_bapb = $request->input('recipient_name_bapb');
            $ship->recipient_name_other = $request->input('recipient_name_other');
            $ship->recipient_phone = $request->input('recipient_phone');
            $ship->recipient_address = $request->input('recipient_address');
            $ship->city_id = $request->input('city_id');
            $ship->price_ton = $request->input('price_ton');
            $ship->price_meter = $request->input('price_meter');
            $ship->minimum_charge = $request->input('minimum_charge');
            $ship->save();
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
