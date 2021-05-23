<?php


namespace App\Http\Controllers;

use App\MsShip;
use App\TrBapb;
use App\TrTracing;
use Carbon\Carbon;
use Exception;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

/**
 * Class TracingController
 *
 * @package App\Http\Controllers
 */
class TracingController extends Controller
{
    public function detail(Request $request)
    {
        try {

            $param = [
                'recipient_id'   => $request->input('recipient_id'),
                'no_container_1' => $request->input('no_container_1'),
                'no_container_2' => $request->input('no_container_2'),
            ];


            $tracing = TrTracing::query()
                ->where('recipient_id', '=', $param['recipient_id'])
                ->where('no_container_1', '=', $param['no_container_1'])
                ->where('no_container_2', '=', $param['no_container_2'])
                ->first();

            if ($tracing && $tracing->attachments) {
                $attachments = [];
                foreach ($tracing->attachments as $idx => $attachment) {
                    $attachments[] = [
                        'path' => $attachment['path'],
                        'url'  => asset(Storage::url($attachment['path'])),
                        'name' => $attachment['name'],
                        'type' => $attachment['type'],
                    ];
                }
                $tracing->attachments = $attachments;

                $creator = $tracing->audits()
                    ->where('event', '=', 'created')
                    ->with('user')
                    ->first();

                if ($creator && $creator->user) {
                    $tracing->created_by =  $creator->user->name;
                }
            }

            $response = CoreResponse::ok([
                'tracing' => $tracing,
            ]);
        } catch (CoreException $e) {
            $response = CoreResponse::fail($e);
        }

        return $response;
    }

    public function save(Request $request)
    {
        $attachments = [];
        try {
            DB::beginTransaction();

            $param = [
                'tracing_id'          => $request->input('tracing_id'),
                'recipient_id'        => $request->input('recipient_id'),
                'no_container_1'      => $request->input('no_container_1'),
                'no_container_2'      => $request->input('no_container_2'),
                'name'                => $request->input('name'),
                'tanggal_terima'      => $request->input('tanggal_terima'),
                'koli'                => $request->input('koli'),
                'description'         => $request->input('description'),
                'attachments'         => json_decode($request->input('attachments'), true),
                'attachments_deleted' => json_decode($request->input('attachments_deleted'), true),
                'files'               => $request->file('files'),
            ];

            $attachments = $param['attachments'];

            if ($param['tracing_id']) {
                $tracing = TrTracing::findOrFail($param['tracing_id']);
            } else {
                $tracing = new TrTracing();
            }

            if ($request->hasFile('files')) {
                foreach ($param['files'] as $file) {
                    $path = $file->getClientOriginalExtension();
                    $name = Uuid::uuid4() . '.' . $path;

                    $path = $file->storeAs('public/tracing', $name);
                    $attachments[] = [
                        'path' => $path,
                        'url'  => asset(Storage::url($path)),
                        'name' => $file->getClientOriginalName(),
                        'type' => $file->getMimeType(),
                    ];
                }
            }

            $tracing->recipient_id = $param['recipient_id'];
            $tracing->no_container_1 = $param['no_container_1'];
            $tracing->no_container_2 = $param['no_container_2'];
            $tracing->name = $param['name'];
            $tracing->tanggal_terima = (new Carbon($param['tanggal_terima']))->setSecond(0);
            $tracing->koli = $param['koli'];
            $tracing->description = $param['description'];
            $tracing->attachments = $attachments;
            $tracing->save();

            $this->deleteStorageFiles($param['attachments_deleted']);

            $response = CoreResponse::ok([
                'tracing' => $tracing,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $this->deleteStorageFiles($attachments);

            $response = CoreResponse::fail($e);
        }

        return $response;
    }

    private function deleteStorageFiles($files)
    {
        foreach ($files as $file) {
            Storage::delete($file['path']);
        }
    }

    public function delete($tracingId)
    {
        try {
            DB::beginTransaction();

            $tracing = TrTracing::findOrFail($tracingId);
            $attachments = $tracing->attachments;
            $tracing->delete();

            $this->deleteStorageFiles($attachments);

            $response = CoreResponse::ok([
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $response = CoreResponse::fail($e);
        }

        return $response;
    }
}
