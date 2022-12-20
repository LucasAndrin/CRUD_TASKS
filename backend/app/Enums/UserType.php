<?php

namespace App\Enums;

enum UserType: int
{
    case ADMIN = 1;
    case COORDINATOR = 2;
    case RESPONSIBLE = 3;
}
