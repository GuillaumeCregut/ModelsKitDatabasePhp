<?php
namespace Editiel98\Manager;

use Editiel98\App;
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
                    if($k==='name'){
                        $searchString.=' WHERE ' . $k .' LIKE :' . $k;
                        $key=':' . $k;
                        $values[$key]='%'.$v.'%';
                        
                    }else{
                        $searchString.=' WHERE ' . $k .'=:' . $k;
                        $key=':' . $k;
                        $values[$key]=$v;
                    }
                }
                else{
                    if($k==='name'){
                        $searchString.=' AND ' . $k . ' Like :' . $k;
                        $key=':' . $k;
                        $values[$key]='%'.$v.'%';
                    }else{
                        $searchString.=' AND ' . $k . '=:' . $k;
                        $key=':' . $k;
                        $values[$key]=$v;
                    }
                }
                $count++;
            }
        }
        $query=$startQuery . $searchString;
        $result=$this->db->prepare($query,$this->className,$values); 
        return $result;
    }

    /**
     * Find an entity in DB by Id
     *
     * @param integer $id
     * @return object : class of the entity
     */
    public function findById(int $id): Entity | null
    {
        $query='SELECT * FROM model_full WHERE id=:id';
        $result=$this->prepareSQL($query,[':id'=>$id],true); 
        if ($result){
            return $result;
        }
        return null;
    }

    /**
     * Return entity from DB by name
     *
     * @param string $name
     * @return Model class of the entity
     */
    public function findByName(string $name): Entity | null
    {
        $query='SELECT id, name FROM ' . $this->table .' WHERE name=:name';
        $result=$this->prepareSQL($query,[':name'=>$name],true); 
        if($result){
            return $result;
        } else return null;
    }

    /**
     * Update an entity in DB
     *
     * @param Model $entity : entity to update
     * @return boolean
     */
    public function update(Entity $entity): bool{
        $query="UPDATE model SET
         builder=:builder,
         category=:category,
         brand=:brand,
         period=:period,
         scale=:scale,
         name=:name,
         reference=:reference,
         scalemates=:scalemates,
         picture=:picture 
         WHERE id=:id";
         $values=[
            ':builder'=>$entity->getBuilderId(),
            ':category'=>$entity->getCategoryId(),
            ':brand'=>$entity->getBrandId(),
            ':period'=>$entity->getPeriodId(),
            ':scale'=>$entity->getScaleId(),
            ':name'=>$entity->getName(),
            ':reference'=>$entity->getRef(),
            ':scalemates'=>$entity->getScalemates(),
            ':picture'=>$entity->getImage(),
            ':id'=>$entity->getId()
         ];
         return $this->execSQL($query,$values);
    }

    /**
     * Store Entity in Database
     *
     * @param Model $entity : Entity to store in DB
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
     * @param Model $entity : Entity to delete
     * @return boolean
     */
    public function delete(Entity $entity) : bool{
        $query='DELETE FROM ' . $this->table . ' WHERE id=:id';
        $id=$entity->getId();
        $oldModel=$this->findById($id);
        $image=$oldModel->getImage();
        $result=$this->execSQL($query,['id'=>$id]);
        if($result){
            if(!is_null($image) || ($image!=='')){
                //Delete image file 
                $baseDirectory=dirname(dirname(dirname(__DIR__))) . '/public/';
                $fileName=$baseDirectory . $image;
                $test=unlink($fileName);
            }
        }
        $result=false;
        return $result;
    }

    public function changeUserModelState(int $id, int $state, int $user) :bool
    {
        //get model
        $querySearch="SELECT model,state FROM model_user WHERE id=:id";
        $value=[':id'=>$id];
        try{
            $modelResult=$this->db->prepare($querySearch,null,$value,true);
            if(!$modelResult){
                return false;
            }
            if($modelResult->state===App::STATE_FINISHED){
                return false;
            }
        }catch(DbException $e){
            return false;
        }

        //Check if model is already user favorite
        if($state==App::STATE_LIKED){
            $idModel=$modelResult->model;
            $queryIsFavorite="SELECT count(*) as nbre FROM model_user WHERE model=:model AND owner=:owner AND state=:state";
            $valueFavorite=[
                ':model'=>$idModel,
                ':owner'=>$user,
                ':state'=>App::STATE_LIKED
            ];
            try{
                $isFavorite=$this->db->prepare($queryIsFavorite,null,$valueFavorite);
                if($isFavorite[0]->nbre===1){
                    return false;
                }
            }catch(DbException $e){
                return false;
            }
        }
        
        $query="UPDATE model_user SET state=:newState WHERE id=:id";
        $values=[
            ':id'=>$id,
            'newState'=>$state
        ];
        try{
            $result=$this->db->exec($query,$values); 
            return $result;
        }catch (DbException $e){
            return false;
        }
    }

    public function getOneFullById(int $id, int $user){
        $query='SELECT * FROM model_fullwithcountry WHERE id=:id AND owner=:owner';
        $values=[
            ':id'=>$id,
            ':owner'=>$user
        ];
        try{
            return $this->db->prepare($query,null,$values,true);
        }catch(DbException $e){
            return null;
        }
    }

    public function getFinishedModels(int $user): array
    {
        //Get array of messages by kit
        $messageError=false;
        $queryMessage="SELECT count(*) as numberMessages, mm.id, mm.fk_model, mu.owner 
        FROM model_message mm 
        INNER JOIN model_user mu ON mm.fk_model=mu.id WHERE mu.owner=:owner GROUP BY mm.fk_model";
        $value=[':owner'=>$user];
        try{
            $messages=$this->db->prepare($queryMessage,null,$value);
        }
        catch(DbException $e){
            $messageError=true;
        }
        $query="SELECT * FROM mymodels WHERE owner=:owner AND state=:state";
        $value[':state']=App::STATE_FINISHED;
        try{
            $models=$this->db->prepare($query,null,$value);
        }
        catch(DbException $e){
            return [];
        }
        //Mix models and messages
        if(!$messageError){
            foreach($models as $model){
                $id=$model->id;
                foreach($messages as $message){
                    if ($message->fk_model===$id){
                        $model->nbMessages=$message->numberMessages;
                    }
                }
            }
        }
        return $models;
    }

    public function updatelinkModelUser(int $idModel, int $idUser,mixed $link): bool
    {
        $query="UPDATE model_user SET pictures=:link WHERE id=:id AND owner=:owner";
        $values=[
            ':id'=>$idModel,
            ':owner'=>$idUser,
            ':link'=>$link
        ];
        try{
            $result=$this->db->exec($query,$values);
            if(!$result){
                return false;
            }
            return true;
        }catch(DbException $e){
            return false;
        }
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