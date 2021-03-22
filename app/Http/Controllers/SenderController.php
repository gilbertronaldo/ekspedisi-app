<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/31/18
 * Time: 11:36 PM
 */

namespace App\Http\Controllers;


use App\MsSender;
use App\TrBapb;
use App\TrBapbSender;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SenderController extends Controller
{
    public function all(Request $request)
    {
        $query = MsSender::get();
        foreach ($query as $q) {
            $q->city_name = '';
            $q->price = '';
            if ($q->city) {
                $q->city_name = $q->city->city_name;
            }

            if ($q->price_ton) {
                $q->price .= 'Rp. ' . $q->price_ton . '/ton';
            }

            if ($q->price_meter) {
                if ($q->price_ton) {
                    $q->price .= ' - ';
                }
                $q->price .= 'Rp. ' . $q->price_meter . '/m';
            }
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

    public function search(Request $request)
    {
        try {
            $text = (string)$request->input('text');
            $page = (int)$request->input('page');
            $limit = (int)$request->input('limit');

            $senderList = MsSender::where('sender_name', 'ilike', "%$text%")
                ->orWhere('sender_code', 'ilike', "%$text%")
                ->orWhere('sender_name_other', 'ilike', "%$text%")
                ->leftjoin('ms_city', 'ms_city.city_id', '=', 'ms_sender.city_id')
                ->offset($page - 1)
                ->limit($limit)
                ->get();
            $count = MsSender::where('sender_name', 'ilike', "%$text%")
                ->orWhere('sender_code', 'ilike', "%$text%")
                ->orWhere('sender_name_other', 'ilike', "%$text%")
                ->count();
            $response = CoreResponse::ok(compact('senderList', 'count'));
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('sender_id')) {
                $data = MsSender::findOrFail($request->input('sender_id'));
            } else {
                $data = new MsSender();

                $existCode = MsSender::where('sender_code', $request->input('sender_code'))
                    ->where('city_id', '=', $request->input('city_id'))
                    ->first();
                $existName = MsSender::where('sender_name_bapb', $request->input('sender_name_bapb'))
                    ->where('city_id', '=', $request->input('city_id'))
                    ->first();

                if ($existCode || $existName) {
                    throw new CoreException("Data pengirim sudah ada! (kode & nama di BAPB)");
                }
            }


            $data->sender_code = $request->input('sender_code');
            $data->sender_name = $request->input('sender_name');
            $data->sender_name_bapb = $request->input('sender_name_bapb');
            $data->sender_name_other = $request->input('sender_name_other');
            $data->sender_phone = $request->input('sender_phone');
            $data->sender_telephone = $request->input('sender_telephone');
            $data->sender_fax = $request->input('sender_fax');
            $data->sender_address = $request->input('sender_address');
            $data->city_id = $request->input('city_id');
            $data->price_ton = $request->input('price_ton');
            $data->price_meter = $request->input('price_meter');
            $data->price_document = $request->input('price_document');
            $data->minimum_charge = $request->input('minimum_charge');
            $data->minimum_charge_calculation_id = $request->input('minimum_charge_calculation_id');
            $data->ambil_di = $request->input('ambil_di');
            $data->email = $request->input('email');
            $data->save();

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
            $sender = MsSender::findOrFail($id);

            $exist = TrBapbSender::query()
                ->select('sender_id')
                ->where('sender_id', '=', $id)
                ->exists();

            if ($exist) {
                throw new CoreException('Penerima telah diinput di BAPB');
            } else {
                $sender->delete();
            }

            $response = CoreResponse::ok();
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}
