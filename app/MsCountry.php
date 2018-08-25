<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/25/18
 * Time: 10:39 PM
 */

namespace App;


use Carbon\Carbon;

/**
 * Class MsCountry
 *
 * @property int country_id
 * @property string country_code
 * @property string country_name
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 * @package App
 */
class MsCountry extends BaseModel
{
    protected $table = 'ms_country';
    protected $primaryKey = 'country_id';
}
