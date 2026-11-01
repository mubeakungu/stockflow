<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;

class SupplierPolicy
{
    /**
     * Determine whether the user can view any suppliers.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the supplier.
     */
    public function view(User $user, Supplier $supplier): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create suppliers.
     */
    public function create(User $user): bool
    {
        // Managers and admins can create suppliers
        //return $user->role?->isManager() ?? false;
        return $user->role !== null; 
    }

    /**
     * Determine whether the user can update the supplier.
     */
    public function update(User $user, Supplier $supplier): bool
    {
        // Managers and admins can update suppliers
        return $user->role?->isManager() ?? false;
    }

    /**
     * Determine whether the user can delete the supplier.
     */
    public function delete(User $user, Supplier $supplier): bool
    {
        // Only admin can delete suppliers
        return $user->role?->isAdmin() ?? false;
    }

    /**
     * Determine whether the user can restore the supplier.
     */
    public function restore(User $user, Supplier $supplier): bool
    {
        return $user->role?->isAdmin() ?? false;
    }

    /**
     * Determine whether the user can permanently delete the supplier.
     */
    public function forceDelete(User $user, Supplier $supplier): bool
    {
        return $user->role?->isAdmin() ?? false;
    }
}
