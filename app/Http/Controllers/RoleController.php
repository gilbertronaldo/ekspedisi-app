<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/9/19
 * Time: 11:33 PM
 */

namespace App\Http\Controllers;

use App\TRole;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;

/**
 * Class RoleController
 *
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{

    /**
     * @return array
     */
    public function all()
    {
        try {
            $roleList = TRole::all();

            $response = CoreResponse::ok(compact('roleList'));
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function get($id)
    {
        try {
            $role = TRole::findOrFail($id);

            $response = CoreResponse::ok($role);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        try {
            $role = TRole::findOrFail($id)->delete();

            $response = CoreResponse::ok($role);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param  $request
     *
     * @return array
     */
    public function save(Request $request)
    {
        try {
            $id = $request->input('role_id');

            if (is_null($request->input('role_name'))
                || $request->input('role_name') == ''
            ) {
                throw new CoreException('Nama Role tidak boleh kosong');
            }


            $exist = TRole::where(
              'role_name',
              '=',
              $request->input('role_name')
            )->first();
            if ( ! is_null($exist)) {
                throw new CoreException('Nama Role sudah terpakai');
            }

            if ($request->has('user_id') && ! is_null($id)) {
                $role = TRole::findOrFail($id);
            } else {
                $role = new TRole();
            }

            $role->role_name = $request->input('role_name');
            $role->save();

            $response = CoreResponse::ok($role);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}
