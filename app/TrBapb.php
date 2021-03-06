<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 9/9/18
 * Time: 7:50 PM
 */

namespace App;


/**
 * Class TrBapb
 *
 * @property integer bapb_id
 * @property string  bapb_no
 * @property string  bapb_description
 * @property integer harga
 * @property integer cost
 * @property integer dimensi
 * @property integer berat
 * @property integer koli
 *
 * @property string  perusahaan
 * @property bool    full_container
 * @property array   full_container_data
 * @package App
 */
class TrBapb extends BaseModel
{

    protected $primaryKey = 'bapb_id';

    protected $table = 'tr_bapb';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'full_container_data' => 'array',
    ];


    public function recipient()
    {
        return $this->belongsTo(MsRecipient::class, 'recipient_id');
    }

    public function senders()
    {
        return $this->hasMany(TrBapbSender::class, 'bapb_id');
    }

    public function ship()
    {
        return $this->belongsTo(MsShip::class, 'ship_id');
    }

    public function delete()
    {
        $senders = $this->senders()->with('items')->get();

        foreach ($senders as $sender) {
            $sender->items()->delete();
            $sender->delete();
        }

        return parent::delete();
    }
}
