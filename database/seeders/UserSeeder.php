<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Model\User\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\User\User::create([
            'nama'                       => 'admin',
            'email'                      => 'creator@admin.com',
            'password'                   => 'password',
            'nomor_hp'                   => '08574908123886',
            'account_type'               => User::ACCOUNT_TYPE_ADMIN,
            'status'                     => User::USER_STATUS_ACTIVE
        ]);
    }
}
