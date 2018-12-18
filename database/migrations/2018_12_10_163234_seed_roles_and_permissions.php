<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        app()['cache']->forget('spatie.permission.cache');

        Permission::create(['name' => 'set site']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage contents']);

        Role::create(['name' => 'founder'])->givePermissionTo(['set site', 'manage users', 'manage contents']);
        Role::create(['name' => 'maintainer'])->givePermissionTo(['manage users', 'manage contents']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
    }
}
