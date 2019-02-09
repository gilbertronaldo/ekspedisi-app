<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/10/19
 * Time: 12:25 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * Class TRoleTask
 *
 * @package App
 */
class TRoleTask extends Model
{
    //    use Cachable;

    protected $table = 't_role_task';

    protected $primaryKey = 'role_task_id';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;
}
