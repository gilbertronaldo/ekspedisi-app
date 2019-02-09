<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/9/19
 * Time: 1:04 PM
 */

namespace App;


use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TRole
 *
 * @package App
 */
class TRole extends Model
{
    use SoftDeletes;
//    use Cachable;

    protected $table = 't_role';

    protected $primaryKey = 'role_id';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;
}
