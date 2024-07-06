<?php

namespace App\Category\Infrastructure\Doctrine;

use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepositoryInterface;
use App\Shared\Infrastructure\Doctrine\EntityRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    use EntityRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return ArrayCollection<Category>
     */
    public function getAll(): ArrayCollection
    {
        $query = $this->getResult($this->createQueryBuilder('c'));

        return new ArrayCollection($query);
    }

    public function getByName(string $name): ?Category
    {
        $query = $this->createQueryBuilder('c')
            ->andWhere('c.name = :name')
            ->setParameter('name', $name);

        return $this->getOneOrNullResult($query);
    }
}
