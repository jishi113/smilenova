<?php

namespace Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Settings\Models\ClinicSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = ClinicSetting::pluck('value', 'key')->toArray();
        return view('settings::index', compact('settings'));
    }

    public function save(Request $request)
    {
        $fields = [
            'clinic_name', 'clinic_tagline', 'clinic_email', 'clinic_phone',
            'clinic_address', 'working_hours', 'footer_text'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                ClinicSetting::updateOrCreate(
                    ['key' => $field],
                    ['value' => $request->input($field), 'group' => 'general']
                );
            }
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}