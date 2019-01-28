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
