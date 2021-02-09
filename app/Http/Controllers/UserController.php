<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/9/19
 * Time: 12:47 PM
 */

namespace App\Http\Controllers;


use App\TTask;
use App\TUserRole;
use App\User;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            $user->roles = DB::table('t_user_role')
                ->select([
                    'role_name',
                ])
                ->join('t_role', function (JoinClause $clause) {
                    $clause->on('t_user_role.role_id', '=', 't_role.role_id');
                    $clause->whereNull('t_role.deleted_at');
                })
                ->where('t_user_role.user_id', '=', $user->id)
                ->get()
                ->pluck('role_name');
            if ($user->id === 1) {
                $tasks = TTask::all()->pluck('task_code');
            } else {
                $tasks = DB::select(
                    "
                    SELECT D.task_code
                    FROM users A
                    INNER JOIN t_user_role B
                       ON A.id = B.user_id
                    INNER JOIN t_role_task C
                        ON B.role_id = C.role_id
                    INNER JOIN t_task D
                        ON C.task_id = D.task_id
                        AND D.deleted_at IS NULL
                    WHERE A.id = $user->id
                    GROUP BY D.task_code
                "
                );

                $tasks = collect($tasks)->map(
                    function ($i) {
                        return strtoupper($i->task_code);
                    }
                );
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
            $userList = User::all()->filter(
                function ($i) {
                    return ! in_array($i->id, [1]);
                }
            );

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
     * @param $id
     *
     * @return array
     */
    public function roles($id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = DB::select(
                "
                SELECT A.user_id, A.role_id, A.city_code
                FROM t_user_role A
                WHERE A.user_id = $user->id
            "
            );

            $response = CoreResponse::ok(compact('user', 'roles'));
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

            $exist = User::where('email', '=', $request->input('email'))->first();
            if (! is_null($exist)) {
                throw new CoreException('Username sudah terpakai');
            }


            if ($request->has('id') && ! is_null($id)) {
                $user = User::findOrFail($id);
            } else {
                $user = new User();
                $user->password = Hash::make('password');
            }

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            $response = CoreResponse::ok($user);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }

    /**
     * @param                          $id
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function saveRoles($id, Request $request)
    {
        try {
            $user = User::findOrFail($id);

            TUserRole::where('user_id', '=', $user->id)->delete();

            $roles = $request->input('roles');
            $roles = collect($roles)->unique(function ($i) {
                return $i['role_id'] . $i['city_code'];
            })->filter(function ($i) {
                return ! is_null($i['role_id']) && ! is_null($i['city_code']);
            });

            if ($roles->isEmpty()) {
                throw new CoreException('Error blank roles');
            }

            foreach ($roles->toArray() as $role) {
                $userRole = new TUserRole();
                $userRole->user_id = $user->id;
                $userRole->role_id = $role['role_id'];
                $userRole->city_code = $role['city_code'];
                $userRole->save();
            }

            $response = CoreResponse::ok(compact('user'));
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

    public function changePassword(Request $request)
    {
        try {
            $id = $request->input('id');
            $password = $request->input('password');

            $user = User::findOrFail($id);
            $user->password = Hash::make($password);
            $user->save();

            $response = CoreResponse::ok($user);
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}
