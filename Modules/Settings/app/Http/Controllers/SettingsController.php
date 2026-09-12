<?php

namespace Modules\Settings\Http\Controllers;

use Modules\Settings\Models\ClinicSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = ClinicSetting::pluck('value', 'key');
        return view('settings::index', compact('settings'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'clinic_name' => ['required', 'string', 'max:150'],
            'clinic_email' => ['required', 'email'],
            'clinic_phone' => ['required', 'string'],
            'clinic_address' => ['nullable', 'string'],
            'clinic_logo' => ['nullable', 'image', 'max:1024'],
            'clinic_tagline' => ['nullable', 'string', 'max:200'],
            'working_hours' => ['nullable', 'string'],
            'footer_text' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('clinic_logo')) {
            $old = ClinicSetting::where('key', 'clinic_logo')->value('value');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('clinic_logo')->store('settings', 'public');
            ClinicSetting::updateOrCreate(['key' => 'clinic_logo'], ['value' => $path, 'group' => 'general']);
        }

        $fields = ['clinic_name', 'clinic_email', 'clinic_phone', 'clinic_address', 'clinic_tagline', 'working_hours', 'footer_text'];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                ClinicSetting::updateOrCreate(['key' => $field], ['value' => $request->input($field), 'group' => 'general']);
            }
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}