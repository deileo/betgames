<?php

namespace App\Task\Domain\Enum;

enum Status: string
{
    case TODO = 'To do';
    case IN_PROGRESS = 'In progress';
    case DONE = 'Done';
}
