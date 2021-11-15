<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userAdm = User::where('name','Admin')->first();
        if($userAdm == null){
            DB::table('users')->insert(
                [
                    'id' => 1,
                    'name' => 'Admin',
                    'username' => 'admin',
                    'email' => 'admin@teste.com.br',
                    'password' => Hash::make('admin'),
                    'api_token' => 'stcNdoonMY3jxPf6nIQCvBwTmCKPr2ypGA0U6KgzN7AkATXxisyw13nNpqlD',
                    'cpf_cnpj' => '15.058.261/0001-30',
                    'active' => '1',
                    'type' => 'common',
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ]
            );
            $userAdm = User::where('name','Admin')->first();
            $userAdm->assignRole('Super-Admin');
        }

        $users = DB::table('users')
                    ->whereIn('name', ['Diego', 'NanoTech'])
                    ->count();
        if($users == 0){
            DB::table('users')->insert(
                [
                    [
                        'id' => 2,
                        'name' => 'Diego',
                        'username' => 'diego',
                        'email' => 'diego@teste.com.br',
                        'password' => Hash::make('diego'),
                        'api_token' => '$2y$10$M6EkjDstqM9pQT4l2OyujenbtEUNO0BV4dch6zb5/L2AcaaNOM38W',
                        'cpf_cnpj' => '456.914.490-01',
                        'active' => '1',
                        'type' => 'common',
                        'created_at' => NOW(),
                        'updated_at' => NOW()
                    ],
                    [
                        'id' => 3,
                        'name' => 'NanoTech',
                        'username' => 'nanoTech',
                        'email' => 'nanoTech@teste.com.br',
                        'password' => Hash::make('nanoTech'),
                        'api_token' => 'vkzAF6aZM8bOhiF0Un6nH6SviNCQrsTUEbWKrlziDLS8GrzD3HeBeIrIkrXT',
                        'cpf_cnpj' => '17.658.435/0501-34',
                        'active' => '1',
                        'type' => 'shopkeeper',
                        'created_at' => NOW(),
                        'updated_at' => NOW()
                    ]
                ]
            );

            DB::table('wallet')->insert(
                [
                    [
                        'user_id' => 1,
                        'balance' => 50,
                        'created_at' => NOW(),
                        'updated_at' => NOW()
                    ],
                    [
                        'user_id' => 2,
                        'balance' => 150,
                        'created_at' => NOW(),
                        'updated_at' => NOW()
                    ],
                    [
                        'user_id' => 3,
                        'balance' => 500,
                        'created_at' => NOW(),
                        'updated_at' => NOW()
                    ]
                ]
            );
        }
    }
}
