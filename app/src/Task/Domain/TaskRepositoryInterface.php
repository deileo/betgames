<?php

namespace App\Task\Domain;

use App\Task\Domain\Request\TaskFilter;
use App\User\Domain\User;
use Doctrine\Common\Collections\ArrayCollection;

interface TaskRepositoryInterface
{
    /**
     * @return ArrayCollection<Task>
     */
    public function getUserTasks(User $user, ?TaskFilter $filter,): ArrayCollection;
}