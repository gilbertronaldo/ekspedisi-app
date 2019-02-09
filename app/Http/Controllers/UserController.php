<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/9/19
 * Time: 12:47 PM
 */

namespace App\Http\Controllers;


use App\TTask;
use App\User;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * get new bapb no
     *
     * @return array
     */
    public function init()
    {
        try {
            $user = auth()->user();

            if ($user->id === 1) {
                $tasks = TTask::all()->pluck('task_code');
            } else {
                $tasks = [];
            }

            $res = [
              'user'  => $user,
              'tasks' => $tasks,
            ];

            $response = CoreResponse::ok($res);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @return array
     */
    public function all()
    {
        try {
            $userList = User::all()->filter(function ($i) {
                return !in_array($i->id, [1]);
            });

            $response = CoreResponse::ok(compact('userList'));
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
            $user = User::findOrFail($id);

            $response = CoreResponse::ok($user);
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
            $id = $request->input('id');

            if (is_null($request->input('email'))
                || $request->input('email') == ''
            ) {
                throw new CoreException('Username tidak boleh kosong');
            }

            if (is_null($request->input('name'))
                || $request->input('name') == ''
            ) {
                throw new CoreException('Nama tidak boleh kosong');
            }

            $exist = User::where('email', '=', $request->input('email'))->first(
            );
            if ( ! is_null($exist)) {
                throw new CoreException('Username sudah terpakai');
            }


            if ($request->has('id') && ! is_null($id)) {
                $user = User::findOrFail($id);
            } else {
                $user           = new User();
                $user->password = Hash::make('password');
            }

            $user->name  = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            $response = CoreResponse::ok($user);
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
            $user = User::findOrFail($id)->delete();

            $response = CoreResponse::ok($user);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}
