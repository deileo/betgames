<?php

namespace App\Task\Application\Query;

use App\Task\Domain\Request\TaskFilter;

readonly class GetUserTasks
{
    public function __construct(
        private ?TaskFilter $filter
    ) {
    }

    public function getFilter(): ?TaskFilter
    {
        return $this->filter;
    }
}
