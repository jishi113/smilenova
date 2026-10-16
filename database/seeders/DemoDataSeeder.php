<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Billing\Models\Service;
use Modules\Doctors\Models\Doctor;
use Modules\Doctors\Models\Specialisation;
use Modules\CMS\Models\Testimonial;
use Modules\CMS\Models\Gallery;
use Modules\Settings\Models\ClinicSetting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // ─── CLINIC SETTINGS ─────────────────────────────────
        $settings = [
            ['key' => 'clinic_name', 'value' => 'SmileNova Dental Care'],
            ['key' => 'clinic_tagline', 'value' => 'Your Smile, Our Passion'],
            ['key' => 'clinic_email', 'value' => 'hello@smilenova.in'],
            ['key' => 'clinic_phone', 'value' => '+91 98765 43210'],
            ['key' => 'clinic_address', 'value' => '123 Marine Drive, Mumbai, Maharashtra 400001'],
            ['key' => 'working_hours', 'value' => 'Mon-Sat: 9:00 AM - 8:00 PM'],
            ['key' => 'footer_text', 'value' => 'Your trusted dental care partner.'],
        ];
        foreach ($settings as $s) {
            ClinicSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // ─── SPECIALISATIONS ─────────────────────────────────
        $specs = [
            ['name' => 'Orthodontist', 'description' => 'Braces & alignment'],
            ['name' => 'Endodontist', 'description' => 'Root canal specialist'],
            ['name' => 'Pediatric Dentist', 'description' => 'Children dentistry'],
            ['name' => 'Periodontist', 'description' => 'Gum specialist'],
        ];
        foreach ($specs as $s) {
            Specialisation::firstOrCreate(['name' => $s['name']], $s);
        }

        // ─── SERVICES ────────────────────────────────────────
        $services = [
            ['name' => 'Teeth Cleaning', 'category' => 'Preventive', 'description' => 'Professional scaling & polishing', 'price' => 1500, 'duration' => 30],
            ['name' => 'Root Canal', 'category' => 'Restorative', 'description' => 'Painless root canal treatment', 'price' => 5000, 'duration' => 60],
            ['name' => 'Braces', 'category' => 'Orthodontic', 'description' => 'Metal & ceramic braces', 'price' => 35000, 'duration' => 45],
            ['name' => 'Teeth Whitening', 'category' => 'Cosmetic', 'description' => 'Laser teeth whitening', 'price' => 8000, 'duration' => 45],
            ['name' => 'Dental Implants', 'category' => 'Surgical', 'description' => 'Titanium implants', 'price' => 25000, 'duration' => 90],
            ['name' => 'Tooth Extraction', 'category' => 'Surgical', 'description' => 'Safe tooth removal', 'price' => 2000, 'duration' => 30],
        ];
        foreach ($services as $s) {
            Service::firstOrCreate(['name' => $s['name']], array_merge($s, ['is_active' => true]));
        }

        // ─── DOCTORS ─────────────────────────────────────────
        $doctorsData = [
            ['name' => 'Dr. Anjali Sharma', 'email' => 'anjali@smilenova.in', 'spec' => 'Orthodontist', 'reg' => 'MH-DEN-001', 'qual' => 'BDS, MDS', 'exp' => 12, 'fee' => 500],
            ['name' => 'Dr. Rajesh Kumar', 'email' => 'rajesh@smilenova.in', 'spec' => 'Endodontist', 'reg' => 'MH-DEN-002', 'qual' => 'BDS, MDS', 'exp' => 10, 'fee' => 600],
            ['name' => 'Dr. Priya Verma', 'email' => 'priya@smilenova.in', 'spec' => 'Pediatric Dentist', 'reg' => 'MH-DEN-003', 'qual' => 'BDS, MDS', 'exp' => 8, 'fee' => 400],
            ['name' => 'Dr. Sameer Khan', 'email' => 'sameer@smilenova.in', 'spec' => 'Periodontist', 'reg' => 'MH-DEN-004', 'qual' => 'BDS, MDS', 'exp' => 15, 'fee' => 700],
        ];
        foreach ($doctorsData as $d) {
            $user = User::firstOrCreate(
                ['email' => $d['email']],
                ['name' => $d['name'], 'password' => Hash::make('Smile@2026'), 'is_active' => true]
            );
            $user->assignRole('dentist');

            $spec = Specialisation::where('name', $d['spec'])->first();

            Doctor::updateOrCreate(
                ['registration_no' => $d['reg']],
                [
                    'user_id' => $user->id,
                    'specialisation_id' => $spec->id,
                    'qualification' => $d['qual'],
                    'experience_years' => $d['exp'],
                    'consultation_fee' => $d['fee'],
                    'bio' => 'Experienced dental professional specializing in ' . $d['spec'] . '.',
                    'is_active' => true,
                ]
            );
        }

        // ─── TESTIMONIALS ────────────────────────────────────
        $testimonials = [
            ['patient_name' => 'Rohan Mehta', 'rating' => 5, 'review' => 'Best dental clinic I have ever visited. Very professional and caring staff!'],
            ['patient_name' => 'Priya Patel', 'rating' => 5, 'review' => 'Got my root canal done here. Completely painless. Highly recommend!'],
            ['patient_name' => 'Amit Singh', 'rating' => 5, 'review' => 'Clean facility, modern equipment, and wonderful doctors.'],
            ['patient_name' => 'Sneha Reddy', 'rating' => 4, 'review' => 'Great experience with teeth whitening. Results were amazing!'],
            ['patient_name' => 'Vikram Joshi', 'rating' => 5, 'review' => 'Dr. Anjali is fantastic with kids. My daughter loves visiting!'],
            ['patient_name' => 'Anita Desai', 'rating' => 5, 'review' => 'Affordable pricing and excellent service. Will definitely come back.'],
        ];
        foreach ($testimonials as $i => $t) {
            Testimonial::firstOrCreate(
                ['patient_name' => $t['patient_name']],
                array_merge($t, ['is_published' => true, 'sort_order' => $i])
            );
        }

        // ─── GALLERY ─────────────────────────────────────────
        $galleryImages = [
            'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=600',
            'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=600',
            'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=600',
            'https://images.unsplash.com/photo-1609840114035-3c981b782dfe?w=600',
            'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?w=600',
            'https://images.unsplash.com/photo-1571772996211-2f02c9727629?w=600',
            'https://images.unsplash.com/photo-1620331311520-246422fd82f9?w=600',
            'https://images.unsplash.com/photo-1595003500447-88ba7c2c6d19?w=600',
        ];
        foreach ($galleryImages as $i => $url) {
            Gallery::firstOrCreate(
                ['image_path' => $url],
                [
                    'title' => 'Clinic Photo ' . ($i + 1),
                    'category' => 'clinic',
                    'is_published' => true,
                    'sort_order' => $i,
                ]
            );
        }

        $this->command->info('✅ Demo data seeded successfully!');
    }
}