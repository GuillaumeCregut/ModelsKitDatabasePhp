<?php
namespace Editiel98\Manager;

/**
 * Manage single entity to DB
 */
abstract class SingleManager extends Manager
{
    /**
     * Get all datas from DB for the entity
     *
     * @return array
     */
    public function getAll():array
    {
        $result=$this->db->query('SELECT id,name FROM ' . $this->table,$this->className); //'Editiel98\Entity\Country'
        return $result;
    }

    /**
     * Find an entity in DB by Id
     *
     * @param integer $id
     * @return object : class of the entity
     */
    public function findById(int $id):object
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
    public function findByName(string $name):object
    {
        $query='SELECT id, name FROM ' . $this->table.' WHERE name=:name';
        $result=$this->db->prepare($query,$this->className,[':name'=>$name],true); 
        return $result;
    }
}