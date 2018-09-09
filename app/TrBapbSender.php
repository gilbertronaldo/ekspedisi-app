<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 9/9/18
 * Time: 9:07 PM
 */

namespace App;


class TrBapbSender extends BaseModel
{
    protected $primaryKey = 'bapb_sender_id';
    protected $table = 'tr_bapb_sender';

    public function bapb()
    {
        return $this->belongsTo(TrBapb::class, 'bapb_id');
    }

    public function items()
    {
        return $this->hasMany(TrBapbSenderItem::class, 'bapb_sender_id');
    }
}
