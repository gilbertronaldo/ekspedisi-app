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
 * @property integer     office_branch_id
 * @property string      office_branch_name
 * @property integer     city_id
 * @property string      bank_account
 * @property string      bank_account_name
 * @property string      bank_account_number
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
     * @param bool   $isPph
     *
     * @return string
     */
    public static function whereCityCode(string $cityCode, bool $isPph)
    {
        return self::with('city')
            ->where('ms_office_branch.is_pph', $isPph)
            ->get()
            ->where('city.city_code', '=', $cityCode)->first();
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
            /**
             * PPH
             */
            self::newData(
                'Jakarta',
                1,
                'BCA',
                'LELY LAY',
                '8790 139 667',
                true
            ),
            self::newData(
                'Banjarmasin',
                2,
                'BCA',
                'PT SUMBER REJEKI SINAR MANDIRI',
                '8790 766 777',
                true
            ),
            self::newData(
                'Samarinda',
                3,
                'BCA',
                'PT SUMBER REJEKI SINAR MANDIRI',
                '8790 766 777',
                true
            ),
            self::newData(
                'Balikpapan',
                4,
                'BCA',
                'PT SUMBER REJEKI SINAR MANDIRI',
                '8790 766 777',
                true
            ),
            self::newData(
                'Makassar',
                5,
                'BCA',
                'PT SUMBER REJEKI SINAR MANDIRI',
                '8790 766 777',
                true
            ),
            /**
             * NON PPH
             */
            self::newData(
                'Jakarta',
                1,
                'BCA',
                'LELY LAY',
                '8790 139 667',
                false
            ),
            self::newData(
                'Banjarmasin',
                2,
                'BCA',
                'LELY LAY',
                '8790 139 667',
                false
            ),
            self::newData(
                'Samarinda',
                3,
                'BCA',
                'Hendra Gunawan Kurniawan',
                '7460 205 772',
                false
            ),
            self::newData(
                'Balikpapan',
                4,
                'BCA',
                'Hendra Gunawan Kurniawan',
                '8790 140 011',
                false
            ),
            self::newData(
                'Makassar',
                5,
                'BCA',
                'Lely Lay',
                '879 008 3637',
                false
            ),
        ];

        MsOfficeBranch::insert($offices);
    }

    /**
     * @param string $officeBranchName
     * @param int    $cityId
     * @param string $bankAccount
     * @param string $bankAccountName
     * @param string $bankAccountNumber
     * @param bool   $isPph
     *
     * @return array
     */
    private static function newData(
        string $officeBranchName,
        int $cityId,
        string $bankAccount,
        string $bankAccountName,
        string $bankAccountNumber,
        bool $isPph
    )
    {
        return [
            'office_branch_name'  => $officeBranchName,
            'city_id'             => $cityId,
            'bank_account'        => $bankAccount,
            'bank_account_name'   => $bankAccountName,
            'bank_account_number' => $bankAccountNumber,
            'is_pph'              => $isPph,
        ];
    }
}
