<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class LoginPage extends Page
{
    protected $user;
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return route('loginForm.route');
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPresent('.login-form')
        ->assertPresent('@signup-btn')
        ->assertPresent('@login-btn');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@login-btn' => '.login-btn',
            '@signup-btn' => '.new-account-btn',
            '@login-form' => '.login-form',
            '@logout-btn' => '.logout-btn',
        ];
    }
    public function fillLoginCredentials(Browser $browser){
        $browser->type('email', $this->user['email'])
            ->type('password', '12345');
    }

    public function fillwrongLoginCredentials(Browser $browser){
        $browser->type('email', 'wrong_email@yahoo.com')
            ->type('password', '12535');
    }

    public function clickLogin(Browser $browser){
        $browser->click('@login-btn');
    }

    public function clickCreateNewAccount(Browser $browser){
        $browser->click('@signup-btn');
    }

    public function clickLogout(Browser $browser){
        $browser->click('@logout-btn');
    }
}
