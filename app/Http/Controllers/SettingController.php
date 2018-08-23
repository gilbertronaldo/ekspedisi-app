<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/23/18
 * Time: 7:33 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Request;

/**
 * Class SiteController
 * @package App\Http\Controllers
 */
class SettingController extends Controller
{
    public function siteInfo(Request $request)
    {
        return response([
            'name' => 'Ekspedisi',
            "locale_switcher" => false,
            'menu' => [
                [
                    'name' => 'Home',
                    'url' => '/',
                    'icon' => 'icon-home'
                ],
                [
                    'name' => 'Logout',
                    'url' => 'logout',
                    'icon' => 'fa fa-lock'
                ]
            ]
        ]);
    }
}
