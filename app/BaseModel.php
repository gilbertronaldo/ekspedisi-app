<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/25/18
 * Time: 9:58 PM
 */

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
    use SoftDeletes;
//    use Cachable;

    public $timestamps = true;
}
