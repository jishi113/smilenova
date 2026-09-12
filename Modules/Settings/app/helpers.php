<?php

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return \Modules\Settings\Models\ClinicSetting::where('key', $key)->value('value') ?? $default;
    }
}