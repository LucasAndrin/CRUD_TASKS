<?php

namespace App\Enums;

// use function PHPUnit\Framework\matches;

enum UserType: int
{
    case Admin = 1;
    case Coordinator = 2;
    case Responsible = 3;
}
