<?php

namespace App\Enums;

enum UserType: int
{
    case ADMIN = 1;
    case COORDINATOR = 2;
    case RESPONSIBLE = 3;

    public static function matches($value) {
        return match($value) {
            UserType::ADMIN->value, UserType::COORDINATOR->value, UserType::RESPONSIBLE->value => true,
            default => false
        };
    }
}
