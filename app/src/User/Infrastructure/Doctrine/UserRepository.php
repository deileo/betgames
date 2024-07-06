<?php

namespace App\User\Infrastructure\Doctrine;

use App\Shared\Infrastructure\Doctrine\EntityRepositoryTrait;
use App\User\Domain\User;
use App\User\Domain\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    use EntityRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserByEmail(string $email): ?User
    {
        $query = $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email);

        return $this->getOneOrNullResult($query);
    }
}