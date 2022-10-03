<?php

namespace Tests\Browser\Pages;

use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class SignupPage extends Page
{
    use withFaker;
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return route('signupForm.route');
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
            ->assertPresent('.login-form')
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
            '@signup-div' => '.signup-section',
            '@signup-btn' => '.signup-btn',
            '@login-link' => '.login-link',
        ];
    }

    public function fillSignupForm(Browser $browser){
        $browser->type('name', $this->faker->userName());
        $browser->type('first_name', $this->faker->firstName);
        $browser->type('last_name', $this->faker->lastName);
        $browser->select('gender');
        $browser->select('day');
        $browser->select('month');
        $browser->select('year');
        $browser->type('email', $this->faker->email());
        $browser->type('phone', $this->faker->numerify("010########"));
        $browser->type('password', '12345');
        $browser->type('password_confirmation','12345');
    }
    public function clickSignup(Browser $browser){
        $browser->click('@signup-btn');

    }
    public function clickLogin(Browser $browser){
        $browser->click('@login-link');
    }
}
