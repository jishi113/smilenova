<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'appointments.view', 'appointments.create', 'appointments.edit',
            'appointments.delete', 'appointments.manage_all',
            'patients.view', 'patients.create', 'patients.edit', 'patients.delete',
            'patients.view_medical_records', 'patients.edit_medical_records',
            'doctors.view', 'doctors.create', 'doctors.edit', 'doctors.delete',
            'billing.view', 'billing.create', 'billing.edit', 'billing.payments',
            'billing.reports',
            'cms.pages', 'cms.posts', 'cms.testimonials', 'cms.gallery', 'cms.services',
            'settings.general', 'settings.email', 'settings.appearance',
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'users.assign_roles',
            'reports.appointments', 'reports.revenue', 'reports.patients',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $clinicAdmin = Role::firstOrCreate(['name' => 'clinic_admin']);
        $clinicAdmin->givePermissionTo([
            'appointments.view','appointments.create','appointments.edit',
            'appointments.delete','appointments.manage_all',
            'patients.view','patients.create','patients.edit','patients.delete',
            'patients.view_medical_records','patients.edit_medical_records',
            'doctors.view','doctors.create','doctors.edit',
            'billing.view','billing.create','billing.edit','billing.payments','billing.reports',
            'cms.pages','cms.posts','cms.testimonials','cms.gallery','cms.services',
            'settings.general','settings.email','settings.appearance',
            'users.view','users.create','users.edit',
            'reports.appointments','reports.revenue','reports.patients',
        ]);

        $dentist = Role::firstOrCreate(['name' => 'dentist']);
        $dentist->givePermissionTo([
            'appointments.view','appointments.edit',
            'patients.view','patients.view_medical_records','patients.edit_medical_records',
            'billing.view',
        ]);

        $receptionist = Role::firstOrCreate(['name' => 'receptionist']);
        $receptionist->givePermissionTo([
            'appointments.view','appointments.create','appointments.edit','appointments.manage_all',
            'patients.view','patients.create','patients.edit',
            'billing.view','billing.create','billing.payments',
        ]);

        $patient = Role::firstOrCreate(['name' => 'patient']);
        $patient->givePermissionTo([
            'appointments.view','appointments.create',
            'patients.view',
            'billing.view',
        ]);

        $accounts = [
            ['name'=>'Super Admin', 'email'=>'superadmin@smilenova.in', 'role'=>'super_admin'],
            ['name'=>'Dr. Anjali Sharma','email'=>'anjali@smilenova.in', 'role'=>'dentist'],
            ['name'=>'Admin Staff', 'email'=>'admin@smilenova.in', 'role'=>'clinic_admin'],
            ['name'=>'Reception Desk','email'=>'reception@smilenova.in', 'role'=>'receptionist'],
            ['name'=>'Test Patient', 'email'=>'patient@example.com', 'role'=>'patient'],
        ];

        foreach ($accounts as $a) {
            $user = User::firstOrCreate(['email' => $a['email']], [
                'name' => $a['name'],
                'password' => \Hash::make('Smile@2026'),
            ]);
            $user->syncRoles([$a['role']]);
        }
    }
}