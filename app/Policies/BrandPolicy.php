<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;

class BrandPolicy
{
    /**
     * Determine whether the user can view any brands.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the brand.
     */
    public function view(User $user, Brand $brand): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create brands.
     */
    public function create(User $user): bool
    {
        // Only managers and admins can create brands
        //return $user->role?->isManager() ?? false;
        return $user->role !== null; 
    }

    /**
     * Determine whether the user can update the brand.
     */
    public function update(User $user, Brand $brand): bool
    {
        // Only managers and admins can update brands
        return $user->role?->isManager() ?? false;
    }

    /**
     * Determine whether the user can delete the brand.
     */
    public function delete(User $user, Brand $brand): bool
    {
        // Only admin can delete brands
        return $user->role?->isAdmin() ?? false;
    }

    /**
     * Determine whether the user can restore the brand.
     */
    public function restore(User $user, Brand $brand): bool
    {
        return $user->role?->isAdmin() ?? false;
    }

    /**
     * Determine whether the user can permanently delete the brand.
     */
    public function forceDelete(User $user, Brand $brand): bool
    {
        return $user->role?->isAdmin() ?? false;
    }
}
