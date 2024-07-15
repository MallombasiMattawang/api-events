<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //permission for posts
        Permission::create(['name' => 'posts.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'posts.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'posts.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'posts.delete', 'guard_name' => 'api']);

        //permission for categories
        Permission::create(['name' => 'categories.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'categories.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'categories.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'categories.delete', 'guard_name' => 'api']);

        //permission for sliders
        Permission::create(['name' => 'sliders.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'sliders.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'sliders.delete', 'guard_name' => 'api']);

        //permission for roles
        Permission::create(['name' => 'roles.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'roles.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'roles.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'roles.delete', 'guard_name' => 'api']);

        //permission for permissions
        Permission::create(['name' => 'permissions.index', 'guard_name' => 'api']);

        //permission for users
        Permission::create(['name' => 'users.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'users.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'users.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'users.delete', 'guard_name' => 'api']);

        //permission for photos
        Permission::create(['name' => 'photos.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'photos.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'photos.delete', 'guard_name' => 'api']);

        //permission for events
        Permission::create(['name' => 'events.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'events.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'events.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'events.delete', 'guard_name' => 'api']);

        //permissions for event_categories
        Permission::create(['name' => 'event_categories.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'event_categories.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'event_categories.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'event_categories.delete', 'guard_name' => 'api']);

        //permissions for event_jerseys
        Permission::create(['name' => 'event_jerseys.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'event_jerseys.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'event_jerseys.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'event_jerseys.delete', 'guard_name' => 'api']);

        //permissions for event_members
        Permission::create(['name' => 'event_members.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'event_members.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'event_members.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'event_members.delete', 'guard_name' => 'api']);
    }
}
