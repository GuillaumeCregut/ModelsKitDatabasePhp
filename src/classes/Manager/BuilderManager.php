<?php
namespace Editiel98\Manager;

use App\Controller\Error as ControllerError;
use Editiel98\Database\Database;
use Editiel98\DbException;
use Editiel98\Entity\Builder;
use Editiel98\Entity\Entity;
use Editiel98\Event\Emitter;
use Editiel98\Flash;

/**
 * Manage single entity to DB
 */
class BuilderManager extends Manager implements ManagerInterface
{
    public function __construct(Database $db)
    {
        $this->db=$db;
        $this->table='builders';
        $this->className='Editiel98\Entity\Builder';
    }

    
    /**
     * Get all datas from DB for the entity
     *
     * @return array
     */
    public function getAll():array
    {
        $query='SELECT b.id,b.name,b.country,c.name as countryName FROM ' 
        . $this->table . 
        ' b INNER JOIN country c on b.country=c.id ORDER BY b.name';
        try{
            $result=$this->db->query($query,$this->className); 
            return $result;
        }
        catch(DbException $e){
            $this->loadErrorPage($e->getdbMessage());
        }
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
        $result=$this->prepareSQL($query,[':id'=>$id],true); 
        return $result;
    }

    /**
     * Return entity from DB by name
     *
     * @param string $name
     * @return object class of the entity
     */
    public function findByName(string $name):Builder
    {
        $query='SELECT id, name FROM ' . $this->table .' WHERE name=:name';
        $result=$this->prepareSQL($query,[':name'=>$name],true); 
        return $result;
    }

    /**
     * Update an entity in DB
     *
     * @param Buidler $entity : entity to update
     * @return boolean
     */
    public function update(Entity $entity): bool{
        $query='UPDATE ' . $this->table .' SET name=:name, country=:country WHERE id=:id';
        $name=$entity->getName();
        $id=$entity->getId();
        $country=$entity->getCountryId();
        $values=['name'=>$name,':id'=>$id,':country'=>$country];
        return $this->execSQL($query,$values);
    }

    /**
     * Store Entity in Database
     *
     * @param Builder $entity : Entity to store in DB
     * @return boolean
     */
    public function save(Entity $entity): bool{
        $query='INSERT INTO ' . $this->table . '(name, country) VALUES (:name,:country)';
        $name=$entity->getName();  
        $country=$entity->getCountryId();
        $result=$this->execSQL($query,['name'=>$name,':country'=>$country]);
        return $result;
    }

    /**
     * Delete an entity into DB
     *
     * @param Builder $entity : Entity to delete
     * @return boolean
     */
    public function delete(Entity $entity) : bool{
        $query='DELETE FROM ' . $this->table . ' WHERE id=:id';
        $id=$entity->getId();
        $result=$this->execSQL($query,['id'=>$id]);
        return $result;
    }

    /**
     * Exec the query
     *
     * @param string $query : Query to execute
     * @param array $vars : vars for the query
     * @return mixed
     */
    private function execSQL(string $query,array $vars): mixed
    {
        try{
            $result=$this->db->exec($query,$vars);
            return $result;
        }
        catch(DbException $e){
            if($e->getDbCode()===23000){
                $flash=new Flash();
                $flash->setFlash('Modification impossible','error');
                return false;
            }
            $message='SQL : ' . $query .'a poser problème';
            $emitter=Emitter::getInstance();
            $emitter->emit(Emitter::DATABASE_ERROR,$message);
            $this->loadErrorPage($e->getdbMessage());
        }

    }

    /**
     * Execute a prepared query
     *
     * @param string $query : query to execute
     * @param array $vars : vars for the query
     * @param boolean $single : return one result or not
     * @return mixed
     */
    private function prepareSQL(string $query, array $vars, bool $single): mixed
    {
        try{
            $result=$this->db->prepare($query,$this->className,$vars,$single);
            return $result;
        }
        catch(DbException $e){
            $message='SQL : ' . $query .'a poser problème';
            $emitter=Emitter::getInstance();
            $emitter->emit(Emitter::DATABASE_ERROR,$message); 
            $this->loadErrorPage($e->getMessage());
        }
    }
}