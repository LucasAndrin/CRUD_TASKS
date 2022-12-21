<?php

namespace App\Enums;

enum TaskStatus: int
{
    case Pending = 1;
    case Progress = 2;
    case Stopped = 3;
    case Completed = 4;
}
