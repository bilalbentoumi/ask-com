<?php

namespace App\Helpers;

use App\Models\Setting;

class Settings
{

    public static function get($key)
    {
        $setting = Setting::where('name', $key)->get()->shift();
        return $setting != null ? $setting->value : '';
    }

    public static function set($key, $value)
    {
        $setting = Setting::where('name', $key)->get()->shift();
        if ($setting != null) {
            $setting->value = $value;
            $setting->save();
        } else {
            $setting = new Setting();
            $setting->name = $key;
            $setting->value = $value;
            $setting->save();
        }
    }
}
