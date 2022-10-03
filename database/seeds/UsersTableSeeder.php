<?php

use App\Profile;
use App\User;
use Illuminate\Database\Seeder;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id'=>'admin_id',
            'email' =>'admin@yahoo.com',
            'password'=>bcrypt('12345'),
        ]);

        User::create([
            'id'=>'ahmed_id',
            'email' =>'ahmed@yahoo.com',
            'password'=>bcrypt('12345'),
        ]);
    }
}
