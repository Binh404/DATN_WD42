<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Giả sử permission_groups đã có 3 nhóm với id 1, 2, 3
        DB::table('permissions')->insert([
            [
                'group_id' => 1,
                'name' => 'View Users',
                'code' => 'view_users',
                'description' => 'Xem danh sách người dùng',
                'resource' => 'users',
                'action' => 'view',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_id' => 1,
                'name' => 'Edit Users',
                'code' => 'edit_users',
                'description' => 'Chỉnh sửa người dùng',
                'resource' => 'users',
                'action' => 'edit',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_id' => 2,
                'name' => 'Assign Roles',
                'code' => 'assign_roles',
                'description' => 'Gán vai trò cho người dùng',
                'resource' => 'roles',
                'action' => 'assign',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_id' => 3,
                'name' => 'Grant Permission',
                'code' => 'grant_permission',
                'description' => 'Cấp quyền cho vai trò',
                'resource' => 'permissions',
                'action' => 'grant',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 