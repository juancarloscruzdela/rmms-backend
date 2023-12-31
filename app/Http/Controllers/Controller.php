<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getIp(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $name = gethostname();
        $device_info = ["ip" => $ip, "name" => $name];
        return response()->json($device_info);
    }
    public function upTime(){
        $data = shell_exec('uptime');
        $uptime = explode(' up ', $data);
        $uptime = explode(',', $uptime[1]);
        $uptime = $uptime[0].', '.$uptime[1];
        echo ($uptime);
    }
    public function getAnnouncement(){
        return response()->file(public_path('announcement.txt'));
    }
    public function getAdminPassword(){
        $pw = trim(file_get_contents('admin_password.txt'));
        return response()->json([
            'password' => $pw
        ]);
    }
    
    public function getTime(){
        $timestamp = Carbon::now('Asia/Manila');
        echo $timestamp;
    }
    
}
