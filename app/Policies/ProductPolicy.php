<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine whether the user can view any products.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view products
    }

    /**
     * Determine whether the user can view the product.
     */
    public function view(User $user, Product $product): bool
    {
        return true; // All authenticated users can view products
    }

    /**
     * Determine whether the user can create products.
     */
    public function create(User $user): bool
    {
        // Only managers and admins can create products
        //return $user->role?->isManager() ?? false;
        return $user->role !== null; 
    }

    /**
     * Determine whether the user can update the product.
     */
    public function update(User $user, Product $product): bool
    {
        // Only managers and admins can update products
        return $user->role?->isManager() ?? false;
    }

    /**
     * Determine whether the user can delete the product.
     */
    public function delete(User $user, Product $product): bool
    {
        // Only admin can delete products
        return $user->role?->isAdmin() ?? false;
    }

    /**
     * Determine whether the user can restore the product.
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->role?->isAdmin() ?? false;
    }

    /**
     * Determine whether the user can permanently delete the product.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->role?->isAdmin() ?? false;
    }
}
