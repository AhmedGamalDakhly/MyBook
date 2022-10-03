<?php

namespace Tests\Feature;

use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignupControllerTest extends TestCase
{
   use RefreshDatabase;

    public function test_signup_page_can_be_rendered()
    {
        $this->withoutExceptionHandling();
        $response=$this->get(route('signupForm.route'));
        $response->assertStatus(200);
        $response->assertSeeText('Date of Birth');
        $response->assertSeeText('Facebook helps you connect and share with the people in your life');

    }
    public function test_user_can_signup()
    {
        //preparation phase
        $user['email']='user'.rand().'@yahoo.com';
        $user['password']='12345';
        $user['password_confirmation']='12345';
        $profileData=collect(factory(Profile::class)->make());
        $signupData=$profileData->merge($user);
        $this->withoutExceptionHandling();

        //action phase
        $response=$this->post(route('signup.route'),$signupData->toArray());
        $createdUser=User::where('email',$user['email'])->first();

        //assertion phase
        $response->assertStatus(302);
        $this->assertDatabaseHas('users',['email'=>$createdUser['email']]);
        $this->assertDatabaseHas('profiles',['user_id'=>$createdUser['id']]);
        $response->assertRedirect(route('loginForm.route'));
    }

    public function test_user_cannot_signup_with_existing_email()
    {
        //creating user and profile (represents the existing user)
        $userID='user_id'.rand();
        $alreadyUser=factory(User::class)->create(['id'=>$userID]);
        $profile=factory(Profile::class)->create(['user_id'=>$userID]);

        $user['email']=$alreadyUser['email'];
        $user['password']='12345';
        $user['password_confirmation']='12345';
        $profileData=collect(factory(Profile::class)->make());
        $signupData=$profileData->merge($user);

        //action phase
        $response=$this->post(route('signup.route'),$signupData->toArray());

        //assertion phase

        $response->assertSessionHasErrors('email','The E-Mail Address has already been taken.');
        //$response->dumpSession();
        $response->assertStatus(302);
    }



}
