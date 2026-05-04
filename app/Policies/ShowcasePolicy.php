<?php

namespace App\Policies;

use App\Models\Showcase;
use App\Models\User;

class ShowcasePolicy
{
    /**
     * Admin can view any showcase.
     * Regular users can only view their own showcases.
     */
    public function view(User $user, Showcase $showcase): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $showcase->user_id;
    }

    /**
     * Only admin can view all showcases (index).
     * Clients are scoped in the controller query itself.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can access dashboard
    }
}