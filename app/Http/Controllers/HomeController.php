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
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    public function home(Request $request)
    {
        return response([
            'title' => 'Welcome to Ekspedisi App',
            'description' => 'Admin Dashboard',
            'button' => [
                'icon' => 'icon-people',
                'variant' => 'primary',
                'text' => 'Users',
                'to' => '/rest/users'
            ]
        ]);
    }
}
