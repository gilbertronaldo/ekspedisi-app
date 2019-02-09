<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/9/19
 * Time: 1:06 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TTask
 *
 * @package App
 */
class TTask extends Model
{

    use SoftDeletes;

    //    use Cachable;

    protected $table = 't_task';

    protected $primaryKey = 'task_id';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = true;
}
