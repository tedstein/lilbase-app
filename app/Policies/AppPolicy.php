<?php

namespace App\Policies;

use App\Models\App;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, App $app)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, App $app)
    {
        return $app->user()->is($user);
    }

    public function delete(User $user, App $app)
    {
        return $this->update($user, $app);
    }

    public function restore(User $user, App $app)
    {
        //
    }

    public function forceDelete(User $user, App $app)
    {
        //
    }
}
