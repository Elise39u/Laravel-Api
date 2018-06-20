<?php
/**
 * Created by PhpStorm.
 * User: justi
 * Date: 5-6-2018
 * Time: 10:21
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use App\Users;
use App\roles;

class YoutubeController extends Controller
{
    public function index() {
        $name = "justin";
        $command = escapeshellcmd("C:/wamp64/www/python/tests/main.py $name");
        $output = shell_exec($command);
        echo $output;
    }
}