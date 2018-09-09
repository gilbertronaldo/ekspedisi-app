<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 9/9/18
 * Time: 9:08 PM
 */

namespace App;


class TrBapbSenderItem extends BaseModel
{
    protected $primaryKey = 'bapb_sender_item_id';
    protected $table = 'tr_bapb_sender_item';

    public function sender()
    {
        return $this->belongsTo(TrBapbSender::class, 'bapb_sender_id');
    }
}
