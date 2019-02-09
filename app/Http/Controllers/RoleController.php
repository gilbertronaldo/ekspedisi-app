<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/9/19
 * Time: 11:33 PM
 */

namespace App\Http\Controllers;

use App\TRole;
use App\TRoleTask;
use App\TTask;
use GilbertRonaldo\CoreSystem\CoreException;
use GilbertRonaldo\CoreSystem\CoreResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $roleList = TRole::all()->filter(
              function ($i)
              {
                  return ! in_array($i->role_id, [1]);
              }
            );;

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

            if ($request->has('role_id') && ! is_null($id)) {
                $role = TRole::findOrFail($id);
            } else {
                $role = new TRole();
            }

            $role->role_name = strtoupper($request->input('role_name'));
            $role->save();

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
    public function tasks($id)
    {
        try {
            $role  = TRole::findOrFail($id);
            $tasks = DB::select(
              "
                SELECT A.task_id, A.task_code, A.task_description,
                       CASE 
                          WHEN B.role_task_id IS NOT NULL 
                          THEN TRUE 
                          ELSE FALSE 
                       END 
                       AS checked
                FROM t_task A 
                LEFT JOIN t_role_task B
                    ON A.task_id = B.task_id
                    AND B.role_id = $role->role_id
                WHERE A.deleted_at IS NULL
            "
            );

            $response = CoreResponse::ok(compact('role', 'tasks'));
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
    public function saveTasks($id, Request $request)
    {
        try {
            $role = TRole::findOrFail($id);

            TRoleTask::where('role_id', $id)->delete();

            foreach ($request->input('tasks') as $id) {
                $task          = new TRoleTask();
                $task->role_id = $role->role_id;
                $task->task_id = $id;
                $task->save();
            }

            $response = CoreResponse::ok(compact('role'));
        } catch (CoreException $exception) {
            $response = CoreResponse::fail($exception);
        }

        return $response;
    }
}
