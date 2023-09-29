<?php
namespace Editiel98\Manager;

use Editiel98\Entity\Entity;

/**
 * Manage single entity to DB
 */
abstract class SingleManager extends Manager implements ManagerInterface
{
    /**
     * Get all datas from DB for the entity
     *
     * @return array
     */
    public function getAll():array
    {
        $result=$this->db->query('SELECT id,name FROM ' . $this->table,$this->className); 
        return $result;
    }

    /**
     * Find an entity in DB by Id
     *
     * @param integer $id
     * @return object : class of the entity
     */
    public function findById(int $id): Entity
    {
        $query='SELECT id, name FROM ' . $this->table.' WHERE id=:id';
        $result=$this->db->prepare($query,$this->className,[':id'=>$id],true); 
        return $result;
    }

    /**
     * Return entity from DB by name
     *
     * @param string $name
     * @return object class of the entity
     */
    public function findByName(string $name):Entity
    {
        $query='SELECT id, name FROM ' . $this->table .' WHERE name=:name';
        $result=$this->db->prepare($query,$this->className,[':name'=>$name],true); 
        return $result;
    }

    public function update(Entity $entity): bool{
        $query='UPDATE ' . $this->table .' SET name=:name WHERE id=:id';
        $name=$entity->getName();
        $id=$entity->getId();
        return $this->db->exec($query,['name'=>$name,':id'=>$id]);
    }

    public function save(Entity $entity): bool{
        $query='INSERT INTO ' . $this->table . '(name) VALUES (:name)';
        $name=$entity->getName();
        $result=$this->db->exec($query,['name'=>$name]);
        return $result;
    }

    public function delete(Entity $entity) : bool{
        $query='DELETE FROM ' . $this->table . ' WHERE id=:id';
        $id=$entity->getId();
        $result=$this->db->exec($query,['id'=>$id]);
        return $result;
    }
}