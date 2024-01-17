<?php

namespace Editiel98\Manager;

use Editiel98\Entity\Entity;

interface ManagerInterface
{
    public function findById(int $id): Entity | null;
    public function getAll(): array;
    public function findByName(string $name): Entity | null;
    public function update(Entity $entity): bool;
    public function save(Entity $entity): bool;
    public function delete(Entity $entity): bool;
}
