<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/25/18
 * Time: 10:43 PM
 */

namespace App;


use Carbon\Carbon;

/**
 * Class MsShip
 *
 * @property int ship_id
 * @property string no_voyage
 * @property string ship_name
 * @property string ship_description
 * @property Carbon sailing_date
 * @property int city_id_from
 * @property int city_id_to
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 *
 * @package App
 */
class MsShip extends BaseModel
{
    protected $table = 'ms_ship';
    protected $primaryKey = 'ship_id';
    protected $casts = [
        'sailing_date'  => 'date:d-m-y'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function cityFrom()
    {
        return $this->belongsTo(MsCity::class, 'city_id_from')->select('city_code');
    }

    public function cityTo()
    {
        return $this->belongsTo(MsCity::class, 'city_id_to')->select('city_code');
    }
}
