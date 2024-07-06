<?php

namespace App\Task\Domain\Enum;

enum Priority: string
{
    case LOW = 'Low';
    case MEDIUM = 'Medium';
    case HIGH = 'High';
}
