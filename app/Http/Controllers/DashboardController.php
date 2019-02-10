<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/9/19
 * Time: 12:23 AM
 */

namespace App\Http\Controllers;


use App\TrBapb;
use App\TrInvoice;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{

    /**
     * get new bapb no
     *
     * @return array
     */
    public function header()
    {
        try {
            $total    = [
              'staff'   => DB::select("
                    SELECT COUNT(DISTINCT A.user_id)
                    FROM t_user_role A 
                    WHERE A.role_id = 3
              ")[0]->count,
              'bapb'    => TrBapb::count(),
              'invoice' => TrInvoice::count(),
              'profit'  => DB::select("
                   SELECT SUM(COALESCE(A.harga,0) + COALESCE(A.cost,0)) AS total
                   FROM tr_bapb A
                   WHERE A.deleted_at IS NULL
              ")[0]->total,
            ];
            $response = CoreResponse::ok(compact('total'));
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}
