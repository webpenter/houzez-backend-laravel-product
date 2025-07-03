<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\AgentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AgentRepository implements AgentRepositoryInterface
{
    public function all(): Collection
    {
        return User::where('role', 'agent')->get();
    }

    public function findByUsername(string $username): ?User
    {
        return User::where('role', 'agent')
                    ->where('username', $username)
                    ->first();
    }
}
