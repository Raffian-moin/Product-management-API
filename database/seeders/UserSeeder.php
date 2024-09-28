<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'customer',
                'email' => 'customer@mail.com',
                'role' => 'customer',
                'password' => Hash::make('12345678'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        try {
            DB::beginTransaction();

            DB::table('users')->insert($users);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

    }
}
