<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Billing\Models\Service;
use Modules\Doctors\Models\Doctor;
use Modules\CMS\Models\Testimonial;
use Modules\CMS\Models\Gallery;
use Modules\Settings\Models\ClinicSetting;
use Modules\Patients\Models\Patient;

class PublicController extends Controller
{
    public function home()
    {
        // Get active services
        $services = Service::where('is_active', true)->take(6)->get();

        // Get active doctors
        $doctors = Doctor::with(['user', 'specialisation'])
            ->where('is_active', true)
            ->take(4)
            ->get();

        // Get published testimonials
        $testimonials = Testimonial::where('is_published', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        // Get published gallery
        $gallery = Gallery::where('is_published', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        // Get clinic settings as key-value pairs
        $clinic = ClinicSetting::pluck('value', 'key')->toArray();

        // Stats
        $stats = [
            'patients' => Patient::where('is_active', true)->count(),
            'doctors' => Doctor::where('is_active', true)->count(),
            'experience' => 10,
            'satisfaction' => 98,
        ];

        return view('website::home', compact(
            'services', 'doctors', 'testimonials', 'gallery', 'clinic', 'stats'
        ));
    }
}