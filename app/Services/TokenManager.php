<?php

namespace App\Services;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

class TokenManager
{
    /**
     * @param User $user
     * @param array|string[] $abilities
     * @return NewAccessToken
     */
    public function createToken(User $user, $name = null, array $abilities = ['*']): NewAccessToken
    {
        return $user->createToken($name ?? config('app.name'), $abilities);
    }

    /**
     * @param User $user
     */
    public function destroyTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}
