<?php
namespace Editiel98\Manager;


use Editiel98\Database\Database;
use Editiel98\DbException;
use Editiel98\Entity\Entity;
use Editiel98\Entity\Model;
use Editiel98\Event\Emitter;
use Editiel98\Flash;

/**
 * Manage single entity to DB
 */
class ModelManager extends Manager implements ManagerInterface
{
    public function __construct(Database $db)
    {
        $this->db=$db;
        $this->table='model';
        $this->className='Editiel98\Entity\Model';
    }

    
    /**
     * Get all datas from DB for the entity
     *
     * @return array
     */
    public function getAll():array
    {
        $query="SELECT id,name, builder, category, brand, period, scale, reference, picture, scalemates,
        buildername, countryid, categoryname, brandname, periodname, scalename, countryname  
        FROM model_full"; 
        try{
            $result=$this->db->query($query,$this->className); 
            return $result;
        }
        catch(DbException $e){
            $this->loadErrorPage($e->getdbMessage());
        }
    }
    
    public function getFiltered(array $filter): array
    {
        $values=[];
        $searchString='';
        $startQuery="SELECT id,name, builder, category, brand, period, scale, reference, picture, scalemates,
        buildername, countryid, categoryname, brandname, periodname, scalename, countryname  
        FROM model_full";
        if(count($filter)>0){
            $count=0;
            foreach($filter as $k=>$v){
                if ($count===0){
                    $searchString.=' WHERE ' . $k .'=:' . $k;
                }
                else{
                    $searchString.=' AND ' . $k . '=:' . $k;
                }
                $key=':' . $k;
                $values[$key]=$v;
                $count++;
            }
        }
        $query=$startQuery . $searchString;
        try{
            $result=$this->db->prepare($query,$this->className,$values); 
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
        // $query='SELECT id, name FROM ' . $this->table.' WHERE id=:id';
        // $result=$this->prepareSQL($query,[':id'=>$id],true); 
        // return $result;
        return new Model();
    }

    /**
     * Return entity from DB by name
     *
     * @param string $name
     * @return object class of the entity
     */
    public function findByName(string $name): Model
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
        // $query='UPDATE ' . $this->table .' SET name=:name, country=:country WHERE id=:id';
        // $name=$entity->getName();
        // $id=$entity->getId();
        // $country=$entity->getCountryId();
        // $values=['name'=>$name,':id'=>$id,':country'=>$country];
        // return $this->execSQL($query,$values);
        //Debug
        return false;
    }

    /**
     * Store Entity in Database
     *
     * @param Builder $entity : Entity to store in DB
     * @return boolean
     */
    public function save(Entity $entity): bool{
        $query="INSERT INTO " . $this->table . 
        "(builder, category, brand, period, scale, name, reference, picture, scalemates) 
        VALUES (:builder, :category, :brand, :period,:scale, :name, :reference, :picture, :scalemates)";
        $values=[
            ":builder"=>$entity->getBuilderId(),
            ":category"=>$entity->getCategoryId(),
            ":brand"=>$entity->getBrandId(),
            ":period"=>$entity->getPeriodId(),
            ":scale"=>$entity->getScaleId(),
            ":name"=>$entity->getName(),
            ":reference"=>$entity->getRef(),
            ":picture"=>$entity->getImage(),
            "scalemates"=>$entity->getScalemates()
        ];
        $result=$this->execSQL($query,$values);
        return $result;
    }

    /**
     * Delete an entity into DB
     *
     * @param Builder $entity : Entity to delete
     * @return boolean
     */
    public function delete(Entity $entity) : bool{
        // $query='DELETE FROM ' . $this->table . ' WHERE id=:id';
        // $id=$entity->getId();
        // $result=$this->execSQL($query,['id'=>$id]);
        // return $result;
        return false;
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