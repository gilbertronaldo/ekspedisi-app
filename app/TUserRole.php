<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/10/19
 * Time: 8:20 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * Class TUserRole
 *
 * @package App
 */
class TUserRole extends Model
{
    //    use Cachable;

    protected $table = 't_user_role';

    protected $primaryKey = 'user_role_id';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;
}
