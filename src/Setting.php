<?php

namespace Aries\LaravelSetting;

use Aries\LaravelSetting\Model\Setting as SettingModel;
use Illuminate\Support\Facades\Cache;

class Setting
{

    public function set($key, $value, $is_primary = false, $autoload = false)
    {
        if (\Cache::has('setting_' . $key)) {
            Cache::forget('setting_' . $key);
        }

        $setting = SettingModel::updateOrCreate([
            'key' => $key
        ], [
            'value' => $value,
            'is_primary' => $is_primary,
            'autoload' => $autoload,
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
                return SettingModel::where('key', $key)->firstOrFail()->value;
            });

            return $setting->value;

        } catch (\Exception $e) {
            return $default;
        }
    }
    
    public function getPrimary()
    {
        try {
            return SettingModel::where('is_primary', true)->pluck('id', 'value')->toArray();

        } catch (\Exception $e) {
            return $default;
        }
    }

    public function store($setting)
    {
        $i = 0;
        foreach($setting as $key => $value) {
            $this->set($key, $value);
            $i++;
        }
        return $i;
    }

}
