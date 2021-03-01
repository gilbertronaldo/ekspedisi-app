<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/25/18
 * Time: 9:58 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * Class BaseModel
 * @package App
 */
abstract class BaseModel extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use SoftDeletes;
    use Auditable;
//    use Cachable;

    public $timestamps = true;
}
