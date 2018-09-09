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
 * @property string bapb_no
 * @property string bapb_description
 *
 * @package App
 */
class TrBapb extends BaseModel
{
    protected $primaryKey = 'bapb_id';
    protected $table = 'tr_bapb';

}
