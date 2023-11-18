<?php

namespace App\Policies;

use App\Models\Caixa;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CaixaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    public function update(User $user, Caixa $caixa): Response
    {
        return $user->id === $caixa->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
