<?php

namespace App\Category\Domain;

use Doctrine\Common\Collections\ArrayCollection;

interface CategoryRepositoryInterface
{
    public function getAll(): ArrayCollection;
    public function getByName(string $name): ?Category;
}
