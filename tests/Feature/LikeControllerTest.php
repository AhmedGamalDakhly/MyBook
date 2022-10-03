<?php

namespace Tests\Feature;

use App\Content;
use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $post;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $userID='user_id'.rand(11111,99999);
        $user=factory(User::class)->create(['id'=>$userID]);
        $this->user=$user;
        $profile=factory(Profile::class)->create(['user_id'=>$userID]);
        $this->post=factory(Content::class)->create(['user_id'=>$userID]);
    }


    public function test_user_can_like_content()
    {
        //preparartion phase (user and content have been created in the setup method)
        $this->withoutExceptionHandling();

        //action phase
        $response=$this->actingAs($this->user,'login')->post(route('like.route',$this->post['id']));
        $likedPost=Content::find($this->post['id']);

        //assertion phase
        $this->assertAuthenticated();
        $response->assertJson(['check'=>'success']);
        $this->assertTrue($likedPost->isLiked($this->user['id']));
    }


    public function test_user_can_unlike_content()
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

}