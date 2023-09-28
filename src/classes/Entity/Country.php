<?php
namespace Editiel98\Entity;

use Editiel98\Database\Database;

class Country {
    private string $name;
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id=$id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name=$name;
        return $this;
    }
}