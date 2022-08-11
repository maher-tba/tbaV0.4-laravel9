<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user){
        return $user->is_admin;
    }
    public function update(User $user, Task $task){
        return in_array($user->role_id,[Role::IS_ADMIN,Role::IS_USER,Role::IS_MANAGER]) || (auth()->check() && $task->user_id == auth()->id()) ; // we can user edit tasks belong of him
    }

    public function delete(User $user, Task $task){
        return $user->is_admin || $task->user_id == auth()->id();
    }
}
