<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PageTesing extends DuskTestCase
{

    public function test_user_can_show_login_page()
    {
        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login-form')
                ->screenshot('/loginTest/show-login-page')
                ->type('email', 'ahmed@yahoo.com')
                ->type('password', '12345')
                ->screenshot('/loginTest/show-login-page-after-typing')
                ->assertPresent('.login-form')
                ->assertPresent('.login-btn');
        });
    }

    public function test_user_can_login()
    {
        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user, 'login')
                ->visit('/home')
                ->screenshot('after-login-page')
                ->assertAuthenticatedAs($user, 'login');
        });
    }


    public function test_user_cannot_login_with_wrong_credentials()
    {

        $this->browse(function (Browser $browser)  {
            $browser->visit('/login-form')
                ->type('email', 'wrong_email@yahoo.com')
                ->type('password', 'wrong_password')
                ->screenshot('/loginTest/1.login_wrong_credentials')
                ->click('.login-btn')
                ->screenshot('/loginTest/2.cannot_login')
                ->assertGuest( 'login');
        });
    }


    public function test_user_can_logout()
    {

        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user, 'login')
                ->visitRoute('home.route')
                ->logout('login')
                ->visit('/home')
                ->screenshot('after-logout-page')
                ->assertGuest();
        });
    }

    public function test_logout_button_link()
    {

        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user, 'login')
                ->visitRoute('home.route')
                ->screenshot('after-login-page 1')
                ->clickLink('logout')
                ->screenshot('after-logout-page 2')
                ->assertGuest();
        });
    }

    public function test_user_clicks_create_new_account_link()
    {

        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('loginForm.route')
                ->screenshot('login-page 1')
                ->click('.new-account-btn')
                ->screenshot('after-clicking-create_new_account_link')
                ->assertGuest();
        });
    }

    public function test_user_can_do_all_login_steps()
    {

        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('loginForm.route')
                ->screenshot('/loginTest/1.show-login-page')
                ->assertPresent('.login-form')
                ->assertPresent('.login-btn')
                ->type('email', $user['email'])
                ->type('password', '12345')
                ->screenshot('/loginTest/2.show-login-page-after-typing')
                ->click('.login-btn')
                ->screenshot('/loginTest/3.after-click-login-btn')
                ->assertUrlIs(route('home.route'))
                ->assertPresent('#homePage')
                ->assertAuthenticatedAs($user, 'login');

        });

    }
}
