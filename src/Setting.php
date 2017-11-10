<?php

namespace Aries\LaravelSetting;

use Aries\LaravelSetting\Model\Setting as SettingModel;
use Illuminate\Support\Facades\Cache;

class Setting
{
    public function set($key, $value)
    {
        if (\Cache::has('setting_' . $key)) {
            Cache::forget('setting_' . $key);
        }

        $setting = SettingModel::updateOrCreate([
            'key' => $key
        ], [
            'value' => $value
        ]);

        Cache::forever('setting_' . $key, $value);

        return $value;
    }

    public function get($key, $default = null)
    {
        try {
            if (Cache::has('setting_' . $key)) {
                return Cache::get('setting_' . $key);
            }

            $setting = Cache::rememberForever('setting_' . $key, function () use ($key) {
                return SettingModel::where('key', $key)->firstOrFail();
            });

            return $setting->value;

        } catch (\Exception $e) {
            return $default;
        }
    }

}