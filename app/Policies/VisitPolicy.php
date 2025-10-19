<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Visit;

class VisitPolicy
{
    /**
     * Determines if the user can view the visit.
     */
    public function view(User $user, Visit $visit): bool
    {
        return $user->isAdmin() || $visit->user_id === $user->id;
    }

    /**
     * Determines if the user can create visits.
     * Commercial users can create, admins can too.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isCommercial();
    }

    /**
     * Determines if the user can update the visit.
     */
    public function update(User $user, Visit $visit): bool
    {
        return $user->isAdmin() || $visit->user_id === $user->id;
    }

    /**
     * Determines if the user can delete the visit.
     */
    public function delete(User $user, Visit $visit): bool
    {
        return $user->isAdmin() || $visit->user_id === $user->id;
    }
}
