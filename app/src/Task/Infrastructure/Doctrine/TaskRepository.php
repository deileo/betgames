<?php

namespace App\Task\Infrastructure\Doctrine;

use App\Shared\Infrastructure\Doctrine\EntityRepositoryTrait;
use App\Task\Domain\Enum\Priority;
use App\Task\Domain\Request\TaskFilter;
use App\Task\Domain\Task;
use App\Task\Domain\TaskRepositoryInterface;
use App\User\Domain\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{
    use EntityRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function getUserTasks(User $user, ?TaskFilter $filter): ArrayCollection
    {
        $query = $this->createQueryBuilder('t')
            ->andWhere('t.user = :user')
            ->setParameter('user', $user);

        if (!$filter) {
            return $this->getResult($query);
        }

        if ($filter->getPriority()) {
            $query->andWhere('t.priority = :priority')
                ->setParameter('priority', $filter->getPriority());
        }

        if ($filter->getStatus()) {
            $query->andWhere('t.status = :status')
                ->setParameter('status', $filter->getStatus());
        }

        if ($filter->getCategory()) {
            $query->leftJoin('t.category', 'c')
                ->andWhere('c.name = :category')
                ->setParameter('category', $filter->getCategory());
        }

        return $this->getResult($query);
    }
}
