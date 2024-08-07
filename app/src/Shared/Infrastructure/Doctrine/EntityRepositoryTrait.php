<?php

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;

trait EntityRepositoryTrait
{
    protected function getResult(QueryBuilder $qb, int $hydrationMode = AbstractQuery::HYDRATE_OBJECT): ArrayCollection
    {
        return new ArrayCollection($qb->getQuery()->getResult($hydrationMode));
    }

    protected function getOneOrNullResult(QueryBuilder $qb, string $hydrationMode = null)
    {
        return $qb->setMaxResults(1)->getQuery()->getOneOrNullResult($hydrationMode);
    }
}