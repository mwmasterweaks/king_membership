<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement("ALTER TABLE employees AUTO_INCREMENT = 11000");

        App\branch::create([
            'id' => '1',
            'name' => 'Main Branch',
            'description' => 'Davao Main Branch',
        ]);
        App\Employee::create([
            'id' => '1',
            'branch_id' => '1',
            'first_name' => 'Test',
            'middle_name' => 'Admin',
            'last_name' => '1',
        ]);

        App\User::create([
            'employee_id' => '1',
            'email' => 'kingmpc',
            'password' => bcrypt('123456789'),
            'remember_token' => str_random(10),
        ]);

        App\Role::create(['name' => 'create_employee']); //1
        App\Role::create(['name' => 'update_employee']); //2
        App\Role::create(['name' => 'delete_employee']); //3
        App\Role::create(['name' => 'create_branch']); //4
        App\Role::create(['name' => 'update_branch']); //5
        App\Role::create(['name' => 'delete_branch']); //6
        App\Role::create(['name' => 'view_application']); //7
        App\Role::create(['name' => 'update_application']); //8
        App\Role::create(['name' => 'delete_application']); //9
        App\Role::create(['name' => 'approve_application']); //10
        App\Role::create(['name' => 'reject_application']); //11
        App\Role::create(['name' => 'admin']); //12
        App\Role::create(['name' => 'subadmin']); //13
        App\Role::create(['name' => 'testrole']); //14

        DB::table('role_user')->insert([
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 1, 'role_id' => 2],
            ['user_id' => 1, 'role_id' => 3],
            ['user_id' => 1, 'role_id' => 4],
            ['user_id' => 1, 'role_id' => 5],
            ['user_id' => 1, 'role_id' => 6],
            ['user_id' => 1, 'role_id' => 7],
            ['user_id' => 1, 'role_id' => 8],
            ['user_id' => 1, 'role_id' => 9],
            ['user_id' => 1, 'role_id' => 10],
            ['user_id' => 1, 'role_id' => 11],
            ['user_id' => 1, 'role_id' => 12],
            ['user_id' => 1, 'role_id' => 13],
            ['user_id' => 1, 'role_id' => 14],

        ]);
    }
}
