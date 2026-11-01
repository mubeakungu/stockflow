<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case STAFF = 'staff';

    /**
     * Get all role values as array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Check if a role is a higher privilege than another
     */
    public function isHigherThan(UserRole $other): bool
    {
        $hierarchy = [
            UserRole::ADMIN->value => 3,
            UserRole::MANAGER->value => 2,
            UserRole::STAFF->value => 1,
        ];

        return $hierarchy[$this->value] > $hierarchy[$other->value];
    }

    /**
     * Check if a role is admin
     */
    public function isAdmin(): bool
    {
        return $this === UserRole::ADMIN;
    }

    /**
     * Check if a role is manager or above
     */
    public function isManager(): bool
    {
        return $this === UserRole::MANAGER || $this === UserRole::ADMIN;
    }
}
