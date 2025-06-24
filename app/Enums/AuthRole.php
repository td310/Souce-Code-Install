<?php
namespace App\Enums;

enum AuthRole: int
{
    case ADMIN = 0;
    case USER = 1;

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::USER => 'User'
        };
    }
}