<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $this->ensureRoleColumnsExist();

        $accounts = [
            [
                'name'      => 'Администратор',
                'email'     => 'admin@beauty-salon.test',
                'password'  => 'admin123',
                'is_admin'  => true,
                'is_staff'  => true,
            ],
            [
                'name'      => 'Сотрудник салона',
                'email'     => 'staff@beauty-salon.test',
                'password'  => 'staff123',
                'is_admin'  => false,
                'is_staff'  => true,
            ],
        ];

        foreach ($accounts as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => $data['password'],
                    'is_admin' => $data['is_admin'],
                    'is_staff' => $data['is_staff'],
                ]
            );
        }
    }

    private function ensureRoleColumnsExist(): void
    {
        if (!Schema::hasColumn('users', 'is_admin') || !Schema::hasColumn('users', 'is_staff')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'is_admin')) {
                    $table->boolean('is_admin')->default(false)->after('password');
                }

                if (!Schema::hasColumn('users', 'is_staff')) {
                    $table->boolean('is_staff')->default(false)->after('is_admin');
                }
            });

            DB::table('users')->whereNull('is_admin')->update(['is_admin' => false]);
            DB::table('users')->whereNull('is_staff')->update(['is_staff' => false]);
        }
    }
}