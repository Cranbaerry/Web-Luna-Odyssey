<?php

namespace App\Http;
use App\Models\WebSettings;
use Auth;

class Helper {
    public static function shout(string $string)
    {
            return strtoupper($string);
    }

    public static function pingServer(): bool
    {
        try {
            $fp = fsockopen('127.0.0.1', 17001, $errno, $errstr, 0.05);
            fclose($fp);
            return true;
        } catch (\Exception $th) {
            null;
        }

        return false;
    }

    public static function getSetting($name) {
        $setting = WebSettings::where('data', $name)->first();
        return $setting->value;
    }

    public static function isOwner(): bool
    {
        return Auth::user() &&  (Auth::user()->id_idx == 98 || Auth::user()->id_idx == 99 || Auth::user()->id_idx == 2);
    }

    public static function isAdmin(): bool
    {
        return Auth::user() &&  (Auth::user()->id_idx == 98 || Auth::user()->id_idx == 99 || Auth::user()->id_idx == 100 || Auth::user()->id_idx == 2);
    }

    public static function getAddress() {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }

        return $_SERVER['REMOTE_ADDR'];
    }
}
