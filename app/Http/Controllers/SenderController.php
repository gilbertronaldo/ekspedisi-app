<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/31/18
 * Time: 11:36 PM
 */

namespace App\Http\Controllers;


use App\MsSender;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SenderController
{
    public function all(Request $request)
    {
        $query = MsSender::get();
        foreach ($query as $q) {
            $q->city_name = $q->city->city_name;
        }
        return datatables()->of($query)->toJson();
    }

    public function get($id)
    {
        try {
            $data = MsSender::findOrFail($id);
            $response = CoreResponse::ok($data);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function store(Request $request)
    {
        try {
            if ($request->has('sender_id')) {
                $data = MsSender::findOrFail($request->input('sender_id'));
            } else {
                $data = new MsSender();
            }

            $data->sender_code = $request->input('sender_code');
            $data->sender_name = $request->input('sender_name');
            $data->sender_name_bapb = $request->input('sender_name_bapb');
            $data->sender_name_other = $request->input('sender_name_other');
            $data->sender_phone = $request->input('sender_phone');
            $data->sender_address = $request->input('sender_address');
            $data->city_id = $request->input('city_id');
            $data->price_ton = $request->input('price_ton');
            $data->price_meter = $request->input('price_meter');
            $data->minimum_charge = $request->input('minimum_charge');
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
            MsSender::findOrFail($id)->delete();
            $response = CoreResponse::ok();
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}
