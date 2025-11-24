<?php

namespace App\Repositories\Interfaces;

use App\Core\Interfaces\RepositoryInterface;
use App\Models\User;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string $email): ?User;
}
