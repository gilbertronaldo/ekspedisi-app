<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/25/18
 * Time: 10:50 PM
 */

namespace App;

use Carbon\Carbon;

/**
 * Class MsRecipient
 *
 * @property int recipient_id
 * @property string recipient_code
 * @property string recipient_name
 * @property string recipient_name_bapb
 * @property string recipient_name_other
 * @property string recipient_phone
 * @property string recipient_address
 * @property int city_id
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 *
 * @package App
 */
class MsRecipient extends BaseModel
{
    protected $table = 'ms_recipient';
    protected $primaryKey = 'recipient_id';
}