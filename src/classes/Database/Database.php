<?php
namespace Editiel98\Database;

use Editiel98\DbException;
use Exception;
use \PDO;
use PDOException;

class Database{
    private string $user;
    private string $host;
    private string $name;
    private string $pass;
    private $pdo;
    private static $_instance;
    public function __construct() {
        $this->loadCredentials();
        
    }

    public static function getInstance()
    {
        if(is_null(self::$_instance)){
            self::$_instance=new Database;
        }
        return self::$_instance;
    }

    public function getConnect()
    {
        if($this->pdo===null){
            try{
                $this->pdo=new PDO('mysql:dbname='. $this->name . ';host='. $this->host,$this->user,$this->pass);
               // $this->pdo=new PDO('mysql:dbname='. 'titi' . ';host='. $this->host,$this->user,$this->pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //Enlever en prod si le try / catch ne le planque pas
            }
            catch(PDOException $e){
                $errCode=$e->getCode();
                $errMessage=$e->getMessage();
                throw new DbException('Erreur de connexion à la base',$errCode,$errMessage);
            }
        }
        return $this->pdo;
    }

    private function loadCredentials()
    {
        try{
            $config= simplexml_load_file(__DIR__ . '/../../config.xml');
            if ($config===false){
                throw new Exception('Impossible de lire les credentials');
            }
            $this->user=$config->login;
            $this->pass=$config->pass;
            $this->name=$config->name;
            $this->host=$config->host;
        }
        catch (Exception $e)
        {
            $errCode=$e->getCode();
            $errMessage=$e->getMessage();
            throw new Exception('Impossible de lire les credentials');
        }
    }

    public function query(string $statement,string $className): array
    {
        try{
            $req=$this->getConnect()->query($statement);
            $datas=$req->fetchAll(PDO::FETCH_CLASS,$className);
            return $datas;
        }
        catch(PDOException $e){
            $errCode=$e->getCode();
            $errMessage=$e->getMessage();
            throw new DbException('Erreur Query',$errCode,$errMessage);
        }
    }

    public function prepare(string $statement,?string $className, ?array $values=[], ?bool $single=false)
    {
        try{
            $req=$this->getConnect()->prepare($statement);
            $req->execute($values);
            if(is_null($className)){
                $req->setFetchMode(PDO::FETCH_OBJ);
            }else{
                $req->setFetchMode(PDO::FETCH_CLASS,$className);
            }
            if ($single){
                $data=$req->fetch();
            }
            else{
                $data=$req->fetchAll();
            }
            return $data;
        }
        catch(PDOException $e){
            $errCode=$e->getCode();
            $errMessage=$e->getMessage();
            throw new DbException('Erreur Prepare',$errCode,$errMessage);
        }
    }

    public function exec(string $statement,array $values) :bool | int
    {
        try{
            $req=$this->getConnect()->prepare($statement);
            $result=$req->execute($values);
            return $result;
        }
        catch(Exception $e){
            $errCode=$e->getCode();
            $errMessage=$e->getMessage();
            throw new DbException('Erreur Exec',$errCode,$errMessage);
        }
    }
}