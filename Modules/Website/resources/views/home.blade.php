@extends('layouts.public')

@section('title', 'SmileNova Dental Care')

@section('content')

{{-- HERO SECTION --}}
<section class="relative bg-gradient-to-br from-primary-50 via-white to-primary-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- Left --}}
            <div>
                <div class="inline-flex items-center gap-2 bg-primary-100 text-primary-700 rounded-full px-4 py-1.5 text-sm font-medium mb-6">
                    <span class="w-2 h-2 rounded-full bg-primary-500"></span>
                    Trusted by {{ $stats['patients'] }}+ patients
                </div>
                <h1 class="text-4xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                    Your Perfect<br>
                    <span class="text-primary-600">Smile</span> Starts Here
                </h1>
                <p class="text-lg text-slate-600 mb-8 max-w-lg">
                    Modern dental care with advanced technology and a gentle touch. Book your appointment in seconds.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#" class="btn-primary text-base px-6 py-3">
                        Book Appointment
                    </a>
                    <a href="#" class="btn-secondary text-base px-6 py-3">
                        Our Services
                    </a>
                </div>
            </div>

            {{-- Right: Hero Image --}}
            <div class="relative">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=800"
                         alt="Dental Clinic"
                         class="w-full h-[500px] object-cover">
                </div>
                <div class="absolute -bottom-6 -left-6 bg-white rounded-xl shadow-xl p-4 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Satisfaction</p>
                        <p class="text-lg font-bold text-slate-800">{{ $stats['satisfaction'] }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS BAR --}}
<section class="bg-slate-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
            <div>
                <p class="text-3xl font-bold text-white">{{ $stats['patients'] }}+</p>
                <p class="text-sm text-slate-400 mt-1">Happy Patients</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ $stats['doctors'] }}+</p>
                <p class="text-sm text-slate-400 mt-1">Expert Doctors</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ $stats['experience'] }}+</p>
                <p class="text-sm text-slate-400 mt-1">Years Experience</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ $stats['satisfaction'] }}%</p>
                <p class="text-sm text-slate-400 mt-1">Satisfaction Rate</p>
            </div>
        </div>
    </div>
</section>

{{-- SERVICES --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-sm font-semibold text-primary-600 uppercase tracking-wider mb-2">Our Services</p>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">Complete Dental Care</h2>
            <p class="text-slate-600 mt-3 max-w-2xl mx-auto">From routine checkups to advanced procedures, we offer a full range of dental treatments.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($services as $service)
                <div class="bg-white border border-slate-200 rounded-xl p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-semibold text-lg text-slate-800 mb-2">{{ $service->name }}</h3>
                    <p class="text-sm text-slate-600 mb-4">{{ $service->description }}</p>
                    <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                        <span class="text-xs text-slate-500">{{ $service->duration }} min</span>
                        <span class="font-bold text-primary-600">₹{{ number_format($service->price) }}</span>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-slate-400 py-8">No services available yet.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- DOCTORS --}}
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-sm font-semibold text-primary-600 uppercase tracking-wider mb-2">Our Team</p>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">Meet Our Doctors</h2>
            <p class="text-slate-600 mt-3 max-w-2xl mx-auto">Experienced professionals dedicated to your dental health.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($doctors as $doctor)
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all text-center p-6">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                        {{ strtoupper(substr($doctor->user->name ?? 'D', 0, 1)) }}
                    </div>
                    <h3 class="font-semibold text-slate-800">{{ $doctor->user->name ?? 'Doctor' }}</h3>
                    <p class="text-xs text-primary-600 font-medium mt-1">{{ $doctor->specialisation->name ?? 'Dentist' }}</p>
                    <p class="text-xs text-slate-500 mt-3">{{ $doctor->experience_years }} years experience</p>
                </div>
            @empty
                <p class="col-span-4 text-center text-slate-400 py-8">No doctors available yet.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- TESTIMONIALS --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-sm font-semibold text-primary-600 uppercase tracking-wider mb-2">Testimonials</p>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">What Our Patients Say</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($testimonials as $t)
                <div class="bg-slate-50 rounded-xl p-6">
                    <div class="flex gap-1 mb-3">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 {{ $i < $t->rating ? 'text-amber-400' : 'text-slate-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-sm text-slate-700 leading-relaxed mb-4">"{{ $t->review }}"</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $t->patient_name }}</p>
                </div>
            @empty
                <p class="col-span-3 text-center text-slate-400 py-8">No testimonials yet.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA BANNER --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl p-10 lg:p-14 text-center text-white">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4">Ready for Your Smile Makeover?</h2>
            <p class="text-primary-100 mb-8 max-w-2xl mx-auto">Book your appointment today and take the first step towards a healthier, brighter smile.</p>
            <a href="#" class="inline-flex items-center gap-2 bg-white text-primary-700 font-semibold px-6 py-3 rounded-lg hover:bg-primary-50 transition">
                Book Appointment
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</section>

@endsection