<?php


namespace App;

/**
 * Class TrTracing
 *
 * @property integer        tracing_id
 * @property integer        bapb_id
 * @property integer        recipient_id
 * @property string         no_container_1
 * @property string         no_container_2
 * @property string         name
 * @property \Carbon\Carbon tanggal_terima
 * @property int            koli
 * @property string         description
 * @property array          attachments
 *
 * @package App
 */
class TrTracing extends BaseModel
{
    protected $primaryKey = 'tracing_id';

    protected $table = 'tr_tracing';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'koli'           => 'integer',
        'attachments'    => 'array',
        'tanggal_terima' => 'datetime',
    ];

    public function bapb()
    {
        return $this->belongsTo(TrBapb::class, 'bapb_id');
    }

    public function recipient()
    {
        return $this->belongsTo(MsRecipient::class, 'recipient_id');
    }
}
