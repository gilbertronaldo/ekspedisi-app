<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 1/29/19
 * Time: 1:35 AM
 */

namespace App;

/**
 * Class TrInvoiceBapb
 *
 * @package App
 */
class TrInvoiceBapb extends BaseModel
{
    protected $primaryKey = 'invoice_bapb_id';
    protected $table = 'tr_invoice_bapb';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function invoice()
    {
        return $this->belongsTo(TrInvoice::class, 'invoice_id');
    }

    public function bapb()
    {
        return $this->belongsTo(TrBapb::class, 'bapb_id');
    }
}
