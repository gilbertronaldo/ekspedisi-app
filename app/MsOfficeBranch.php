<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 2/8/19
 * Time: 6:30 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class MsOfficeBranch
 *
 * @property integer office_branch_id
 * @property string  office_branch_name
 * @property integer city_id
 * @property string  bank_account
 * @property string  bank_account_name
 * @property string  bank_account_number
 *
 * @property \App\MsCity city
 *
 * @package App
 */
class MsOfficeBranch extends BaseModel
{

    protected $table = 'ms_office_branch';

    protected $primaryKey = 'office_branch_id';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(MsCity::class, 'city_id');
    }

    /**
     * @param string $cityCode
     *
     * @return string
     */
    public static function whereCityCode(string $cityCode)
    {
        return self::with('city')->get()->where('city.city_code', '=', $cityCode)->first();
    }

    /**
     * @return void
     */
    public static function createData()
    {
        if (self::all()->isNotEmpty()) {
            return;
        }

        $offices = [
          self::newData(
            'Banjarmasin',
            2,
            'BCA',
            'LELY LAY',
            '8790 139 667'
          ),
          self::newData(
            'Samarinda',
            3,
            'BCA',
            'Hendra Gunawan Kurniawan',
            '7460 205 772'
          ),
          self::newData(
            'Balikpapan',
            4,
            'BCA',
            'Hendra Gunawan Kurniawan',
            '8790 140 011'
          ),
          self::newData(
            'Makassar',
            5,
            'BCA',
            'Lely Lay',
            '879 008 3637'
          ),
        ];

        MsOfficeBranch::insert($offices);
    }

    /**
     * @param $officeBranchName
     * @param $cityId
     * @param $bankAccount
     * @param $bankAccountName
     * @param $bankAccountNumber
     *
     * @return array
     */
    private static function newData(
      string $officeBranchName,
      int $cityId,
      string $bankAccount,
      string $bankAccountName,
      string $bankAccountNumber
    ) {
        return [
          'office_branch_name'  => $officeBranchName,
          'city_id'             => $cityId,
          'bank_account'        => $bankAccount,
          'bank_account_name'   => $bankAccountName,
          'bank_account_number' => $bankAccountNumber,
        ];
    }
}
