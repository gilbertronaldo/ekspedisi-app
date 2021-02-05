<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 1/29/19
 * Time: 1:33 AM
 */

namespace App;


/**
 * Class TrInvoice
 *
 * @property integer        invoice_id
 * @property string         invoice_no
 * @property boolean        is_paid
 * @property integer        payment_total
 * @property \Carbon\Carbon payment_date
 *
 * @property  string        pajak
 * @property boolean        is_pph
 *
 * @package App
 */
class TrInvoice extends BaseModel
{

    protected $primaryKey = 'invoice_id';

    protected $table = 'tr_invoice';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function invoiceBapb()
    {
        return $this->hasMany(TrInvoiceBapb::class, 'invoice_id');
    }

    public function delete()
    {
        $invoiceBapbList = $this->invoiceBapb()->get();

        foreach ($invoiceBapbList as $invoiceBapb) {
            $invoiceBapb->delete();
        }

        return parent::delete();
    }
}
