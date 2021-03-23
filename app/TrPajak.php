<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * Class TrPajak
 *
 * @property \Carbon\Carbon date
 * @property float          ppn
 * @property float          pph_23
 *
 * @package App
 */
class TrPajak extends Model
{
    protected $primaryKey = 'date';

    protected $table = 'tr_pajak';

    protected $dateFormat = 'Y-m-d';

    protected $casts = [
        'date' => 'date',
    ];

    protected $fillable = [
        'date',
        'ppn',
        'pph_23',
    ];

    public $timestamps = false;
}
