<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'          => 'SuperAdmin',
            'employee_id'   => 'SuperAdmin@mail.com',
            'password'      => Hash::make('admin123'),
            'password_str'  => 'admin123',
            'branch_id'     => 0,
            'department_id' => 1
        ]);
    }
}
