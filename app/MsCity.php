<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/25/18
 * Time: 10:08 PM
 */

namespace App;

use Carbon\Carbon;

/**
 * Class MsCity
 *
 * @property int city_id
 * @property string city_name
 * @property string city_code
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 *
 * @package App
 */
class MsCity extends BaseModel
{
    protected $table = 'ms_city';
    protected $primaryKey = 'city_id';

    
}
