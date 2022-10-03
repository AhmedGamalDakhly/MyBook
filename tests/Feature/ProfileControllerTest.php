<?php

namespace Tests\Feature;

use App\Content;
use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $userID='user_id'.rand(11111,99999);
        $user=factory(User::class)->create(['id'=>$userID]);
        $this->user=$user;
        $profile=factory(Profile::class)->create(['user_id'=>$userID]);
        $this->post=factory(Content::class)->create(['user_id'=>$userID]);
    }


    public function test_profile_page_can_be_rendered()
    {

        //preparartion phase (user and content have been created in the setup method)
        $this->withoutExceptionHandling();

        //action phase
        $response=$this->actingAs($this->user,'login')->get(route('profile.route'));

        //assertion phase
        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSeeText( 'Edit Profile');
        $response->assertSeeText('Edit Cover Photo',false);

    }


    public function test_user_can_change_cover_image()
    {

        //preparartion phase (user and content have been created in the setup method)
        $this->withoutExceptionHandling();
        $likedPost=Content::find($this->post['id']);
        $likedPost->like($this->user['id']);

        //action phase
        $response=$this->actingAs($this->user,'login')->post(route('like.route',$this->post['id']));
        $unLikedPost=Content::find($this->post['id']);

        //assertion phase
        $this->assertAuthenticated();
        $response->assertJson(['check'=>'success']);
        $this->assertFalse($unLikedPost->isLiked($this->user['id']));
    }

    public function test_user_can_change_profile_image()
    {

        //preparartion phase (user and content have been created in the setup method)
        $this->withoutExceptionHandling();
        $likedPost=Content::find($this->post['id']);
        $likedPost->like($this->user['id']);

        //action phase
        $response=$this->actingAs($this->user,'login')->post(route('like.route',$this->post['id']));
        $unLikedPost=Content::find($this->post['id']);

        //assertion phase
        $this->assertAuthenticated();
        $response->assertJson(['check'=>'success']);
        $this->assertFalse($unLikedPost->isLiked($this->user['id']));
    }

    public function test_user__can_change_profile_settings()
    {

        //preparartion phase (user and content have been created in the setup method)
        $this->withoutExceptionHandling();

        //action phase
        $response=$this->actingAs($this->user,'login')->get(route('profile.route'));

        //assertion phase
        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSeeText( 'Edit Profile');
        $response->assertSeeText('Edit Cover Photo',false);

    }

    public function test_user_can_render_profile_settings()
    {

        //preparartion phase (user and content have been created in the setup method)
        $this->withoutExceptionHandling();

        //action phase
        $response=$this->actingAs($this->user,'login')->get(route('profile.route'));

        //assertion phase
        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSeeText( 'Edit Profile');
        $response->assertSeeText('Edit Cover Photo',false);

    }
}
