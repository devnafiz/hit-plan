<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        Role::updateOrCreate(['id' => 1], [
            'id' => 1,
            'type' => 'admin',
            'name' => 'Administrator',
        ]);

        // Non Grouped Permissions
        $this->truncate('permissions');

        // Grouped permissions
        // Users category
        $users = Permission::create([
            'type' => 'admin',
            'name' => 'admin.access.user',
            'description' => 'All User Permissions',
        ]);

        $users->children()->saveMany([
            new Permission([
                'type' => 'admin',
                'name' => 'admin.access.user.list',
                'description' => 'View Users',
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.deactivate',
                'description' => 'Deactivate Users',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.reactivate',
                'description' => 'Reactivate Users',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.clear-session',
                'description' => 'Clear User Sessions',
                'sort' => 4,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.impersonate',
                'description' => 'Impersonate Users',
                'sort' => 5,
            ]),
            new Permission([
                'type' => User::TYPE_ADMIN,
                'name' => 'admin.access.user.change-password',
                'description' => 'Change User Passwords',
                'sort' => 6,
            ]),
            new Permission([
                'type' => 'admin',
                'name' => 'agent.access.member.list',
                'description' => 'Access member list',
                'sort' => 7,
            ]),
            new Permission([
                'type' => 'admin',
                'name' => 'agent.show.member',
                'description' => 'Show member details',
                'sort' => 8,
            ]),
            new Permission([
                'type' => 'admin',
                'name' => 'agent.update.member',
                'description' => 'Agent can be update member information',
                'sort' => 9,
            ]),
            new Permission([
                'type' => 'admin',
                'name' => 'agent.destroy.member',
                'description' => 'Agent can be delete member',
                'sort' => 10,
            ]),
            new Permission([
                'type' => 'admin',
                'name' => 'agent.create.member',
                'description' => 'Agent can be create member',
                'sort' => 11,
            ]),

        ]);

        // php artisan db:seed --class="Database\\Seeders\\Auth\\PermissionRoleSeeder"

        // Assign Permissions to other Roles

        $this->enableForeignKeys();
    }
}
