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
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function bapb()
    {
        return $this->belongsTo(TrBapb::class, 'bapb_id');
    }

    public function sender()
    {
        return $this->belongsTo(MsSender::class, 'sender_id');
    }

    public function items()
    {
        return $this->hasMany(TrBapbSenderItem::class, 'bapb_sender_id');
    }

    public function costs()
    {
        return $this->hasMany(TrBapbSenderCost::class, 'bapb_sender_id');
    }
}
