<?php

namespace App\Fixtures\Providers;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashPasswordProvider
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function hashPassword(string $plainPassword): string
    {
        return $this->hasher->hashPassword(new User, $plainPassword);
    }
}