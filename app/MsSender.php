<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/25/18
 * Time: 10:57 PM
 */

namespace App;


use Carbon\Carbon;

/**
 * Class Mssender
 *
 * @property int sender_id
 * @property string sender_code
 * @property string sender_name
 * @property string sender_name_bapb
 * @property string sender_name_other
 * @property string sender_phone
 * @property string sender_address
 * @property int city_id
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 *
 * @package App
 */
class MsSender extends BaseModel
{
    protected $table = 'ms_sender';
    protected $primaryKey = 'sender_id';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function city()
    {
        return $this->belongsTo(MsCity::class, 'city_id')->select('city_name');
    }
}
