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
        $this->table='orders';
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

    /**
     * Save order in DB
     *
     * @param Order $entity
     * @return boolean
     */
    public function save(Entity $entity): bool
    {
        
        //On commence une opération de transaction
        try{
            $this->db->startTransac();
            $query="INSERT INTO orders (owner,provider,reference,dateOrder) VALUES (:owner,:provider,:ref,:dateOrder)";
            $values=[
                ':owner'=>$entity->getOwner(),
                ':provider'=>$entity->getProvider(),
                ':ref'=>$entity->getRef(),
                ':dateOrder'=>$entity->getDateOrder()
            ];
            //On ajoute la commande
            $result=$this->db->exec($query,$values);
            if($result!==1){
                return false;
            }
            $lines=$entity->getLines();
            foreach($lines as $line){
                $query_add_modelOrder="INSERT INTO model_order (model_id,order_id,price,qtte) VALUES (:idmodel,:orderRef,:price,:qty)";
                $valuesOrder=[
                    ':idmodel'=>$line['id'],
                    ':orderRef'=>$entity->getRef(),
                    ':price'=>$line['price'],
                    ':qty'=>$line['qty']
                ];
                try{
                    $result=$this->db->exec($query_add_modelOrder,$valuesOrder);
                }catch(DbException $e){
                    $this->db->rollBack();
                    return false;
                }
                //Add Every qtty to user model table
                $quantity=$line['qty'];
                for($i=0;$i<$quantity;$i++){
                    $queryModelUser="INSERT INTO model_user (price,model,owner,provider,state) VALUES (:price,:model,:owner,:provider,5)";
                    $valuesModelUser=[
                        ':price'=>$line['price'],
                        ':model'=>$line['id'],
                        ':owner'=>$entity->getOwner(),
                        ':provider'=>$entity->getProvider()
                    ];
                    try{
                        $result=$this->db->exec($queryModelUser,$valuesModelUser);
                    }catch(DbException $e){
                        $this->db->rollBack();
                        return false;
                    }
                }
            }
            //On fini l'opération de transaction
            $this->db->commitTransc();
            return true;
        }catch(DbException $e){
            $this->db->rollBack();
            return false;
        }
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
