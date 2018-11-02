<?php
/**
 * @author gilbertronaldo gilbert.ronaldo@binus.edu
 * 02 November 2018
 */

namespace App;


class TrBapbSenderCost extends BaseModel
{
    protected $primaryKey = 'bapb_sender_cost_id';
    protected $table = 'tr_bapb_sender_cost';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function sender()
    {
        return $this->belongsTo(TrBapbSender::class, 'bapb_sender_id');
    }
}
