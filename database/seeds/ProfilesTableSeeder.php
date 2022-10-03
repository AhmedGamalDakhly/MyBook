<?php

use App\Profile;
use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
            'user_id'=>'admin_id',
            'path' => 'Admin Path',
            'about' => 'admin of the site',
            'name' => 'Facebook Admin', // password
            'first_name' =>'admin',
            'last_name' =>'admin',
            'tag' => 'Facebook Admin',
            'gender' => 'male', // password
            'phone' =>'01111111111',
            'status' => 'active',
            'date_of_birth' => date('d-m-y h:i:s'),
            'image' => 'default.png', // password
            'cover' =>'cover.jpg',
        ]);

        Profile::create([
            'user_id'=>'ahmed_id',
            'path' => 'ahmed path',
            'about' => 'facebook user',
            'name' => 'AhmedGamal', // password
            'first_name' =>'ahmed',
            'last_name' =>'gamal',
            'tag' => 'AhmedGD',
            'gender' => 'male', // password
            'phone' =>'01020018936',
            'status' => 'active',
            'date_of_birth' => date('d-m-y h:i:s'),
            'image' => 'default.png', // password
            'cover' =>'cover.jpg',
        ]);
    }
}
