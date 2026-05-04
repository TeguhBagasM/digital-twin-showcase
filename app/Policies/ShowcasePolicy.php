<?php

namespace App\Policies;

use App\Models\Showcase;
use App\Models\User;

class ShowcasePolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->isAdmin() ? true : null;
    }

    /**
     * Admin can view any showcase.
     * Regular users can only view their own showcases.
     */
    public function view(User $user, Showcase $showcase): bool
    {
        return $user->id === $showcase->user_id;
    }

    /**
     * Only admin can view all showcases (index).
     * Clients are scoped in the controller query itself.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Showcase $showcase): bool
    {
        return $user->id === $showcase->user_id;
    }

    public function delete(User $user, Showcase $showcase): bool
    {
        return $user->id === $showcase->user_id;
    }
}