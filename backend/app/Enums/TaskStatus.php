<?php

namespace App\Enums;

enum TaskStatus: int
{
    case Pending = 1;
    case Progress = 2;
    case Stop = 3;
    case Completed = 4;
}
