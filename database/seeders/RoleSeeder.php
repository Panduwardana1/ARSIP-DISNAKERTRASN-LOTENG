<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Roles
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $staf  = Role::firstOrCreate(['name' => 'staf', 'guard_name' => 'web']);

        // Permissions
        $permissions = [
            'manage_users',
            'view_dashboard',
            'manage_master',
            'manage_cpmis',
            'manage_rekomendasi',
            'manage_perusahaan',
            'view_activity_log',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        $admin->givePermissionTo(Permission::all());

        $staf->givePermissionTo(['manage_master']);

        $user = User::updateOrCreate(
            ['nip' => '198201182002121001'],
            [
                'name' => 'Admin Diasnaker',
                'email' => 'disnaker@gmail.com',
                'password' => Hash::make('#admin123'),
                'is_active' => 'active',
            ]
        );

        $user->syncRoles([$admin->name]);
    }
}
