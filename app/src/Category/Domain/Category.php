<?php

namespace App\Category\Domain;

use App\Category\Domain\Response\CategoryResponse;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'categories')]
#[UniqueEntity('name')]
#[ORM\Index(name: 'category_name_idx', columns: ['name'])]
class Category
{
    Use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(unique: true)]
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function toResponse(): CategoryResponse
    {
        return new CategoryResponse(
            $this->getId(),
            $this->getName()
        );
    }
}
