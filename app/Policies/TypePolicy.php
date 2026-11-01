<?php

namespace App\Policies;

use App\Models\Type;
use App\Models\User;

class TypePolicy
{
    /**
     * Determine whether the user can view any types.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the type.
     */
    public function view(User $user, Type $type): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create types.
     */
    public function create(User $user): bool
    {
        // Only managers and admins can create types
        return $user->role?->isManager() ?? false;
    }

    /**
     * Determine whether the user can update the type.
     */
    public function update(User $user, Type $type): bool
    {
        // Only managers and admins can update types
        return $user->role?->isManager() ?? false;
    }

    /**
     * Determine whether the user can delete the type.
     */
    public function delete(User $user, Type $type): bool
    {
        // Only admin can delete types
        return $user->role?->isAdmin() ?? false;
    }

    /**
     * Determine whether the user can restore the type.
     */
    public function restore(User $user, Type $type): bool
    {
        return $user->role?->isAdmin() ?? false;
    }

    /**
     * Determine whether the user can permanently delete the type.
     */
    public function forceDelete(User $user, Type $type): bool
    {
        return $user->role?->isAdmin() ?? false;
    }
}
