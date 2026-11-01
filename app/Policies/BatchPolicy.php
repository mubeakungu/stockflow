<?php

namespace App\Policies;

use App\Models\Batch;
use App\Models\User;

class BatchPolicy
{
    /**
     * Determine whether the user can view any batches.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the batch.
     */
    public function view(User $user, Batch $batch): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create batches.
     */
    public function create(User $user): bool
    {
        // Only managers and admins can create batches
        //return $user->role?->isManager() ?? false;
        return $user->role !== null; 
    }

    /**
     * Determine whether the user can update the batch.
     */
    public function update(User $user, Batch $batch): bool
    {
        // Only managers and admins can update batches
        return $user->role?->isManager() ?? false;
    }

    /**
     * Determine whether the user can delete the batch.
     */
    public function delete(User $user, Batch $batch): bool
    {
        // Only admin can delete batches
        return $user->role?->isAdmin() ?? false;
    }

    /**
     * Determine whether the user can restore the batch.
     */
    public function restore(User $user, Batch $batch): bool
    {
        return $user->role?->isAdmin() ?? false;
    }

    /**
     * Determine whether the user can permanently delete the batch.
     */
    public function forceDelete(User $user, Batch $batch): bool
    {
        return $user->role?->isAdmin() ?? false;
    }
}
