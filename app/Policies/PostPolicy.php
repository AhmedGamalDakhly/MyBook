<?php

namespace App\Policies;

use App\Group;
use App\Content;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Content  $post
     * @return mixed
     */
    public function view(User $user,Group $groupID)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Content  $post
     * @return mixed
     */
    public function update(User $user, Content $post)
    {
        //
        return $user['id'] === $post['user_id'] ?
            Response::allow('Content Updated') :
            Response::deny('Not Authorized To Update This Content');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Content  $post
     * @return mixed
     */
    public function delete(User $user, Content $post)
    {
        return $user['id'] === $post['user_id'] ?
        Response::allow('Content Deleted') :
        Response::deny('Not Authorized To Delete This Content');
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Content  $post
     * @return mixed
     */
    public function restore(User $user, Content $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Content  $post
     * @return mixed
     */
    public function forceDelete(User $user, Content $post)
    {
        //
    }
}
