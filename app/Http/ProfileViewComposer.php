<?php


namespace App\Http;


use App\User;
use Illuminate\View\View;

class ProfileViewComposer
{
    protected $user;
    /**
     * Create a new profile composer.
     * *
    @param
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
* Bind data to the view.(Make profile data of the current user available to view)
* *
@param \Illuminate\View\View $view
* @return void
*/
    public function compose(View $view)
    {
        $currentUserProfile=$this->user->profile;
        $view->with('currentUserProfile',$currentUserProfile);
    }
}
