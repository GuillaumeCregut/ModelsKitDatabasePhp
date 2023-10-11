<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;
use Editiel98\DbException;
use Editiel98\Entity\Entity;
use Editiel98\Event\Emitter;
use Editiel98\Flash;
use stdClass;

class OrderManager extends Manager implements ManagerInterface
{
    public function __construct(Database $db)
    {
        $this->db=$db;
        $this->table='model';
        $this->className='Editiel98\Entity\Order';
    }

    public function getAll(): array
    {
        return [];
    }

    public function findById(int $id): ?Entity
    {
        return null;
    }

    public function findByName(string $name): ?Entity
    {
        return null;
    }

    public function findByRef(string $ref): array
    {
        $query="SELECT o.reference, DATE_FORMAT(o.dateOrder,\"%d/%m/%Y\") as dateOrder, p.name FROM orders o INNER JOIN provider p ON o.provider=p.id WHERE o.reference=:ref";
        $values=[':ref'=>$ref];
        try{
           return $this->db->prepare($query,$this->className,$values);
        }
        catch(DbException $e){
            $message='SQL : ' . $query .'a poser problème';
            $emitter=Emitter::getInstance();
            $emitter->emit(Emitter::DATABASE_ERROR,$message);
            return [];
        }
    }

    public function findDetailsByRef(string $ref): array
    {
        $query="SELECT mo.id, mo.model_id,mo.qtte,mo.price,m.name 
        FROM model_order mo INNER JOIN model m ON mo.model_id=m.id WHERE mo.order_id=:ref";
        $values=[':ref'=>$ref];
        try{
           return $this->db->prepare($query,null,$values);
        }
        catch(DbException $e){
            $message='SQL : ' . $query .'a poser problème';
            $emitter=Emitter::getInstance();
            $emitter->emit(Emitter::DATABASE_ERROR,$message);
            return [];
        }
    }

    public function save(Entity $entity): bool
    {
        return false;
    }

    public function update(Entity $entity): bool
    {
        return false;
    }

    public function delete(Entity $entity): bool
    {
        return false;
    }

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
            $message='SQL : ' . $query .' a poser problème';
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



/*

*/