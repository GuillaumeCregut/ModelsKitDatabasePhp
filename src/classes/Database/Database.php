<?php
namespace Editiel98\Database;

use \PDO;

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
            $this->pdo=new PDO('mysql:dbname='. $this->name . ';host='. $this->host,$this->user,$this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //Enlever en prod si le try / catch ne le planque pas
        }
        return $this->pdo;
    }

    private function loadCredentials()
    {
        $config= simplexml_load_file(__DIR__ . '/../../config.xml');
        $this->user=$config->login;
        $this->pass=$config->pass;
        $this->name=$config->name;
        $this->host=$config->host;
    }

    public function query(string $statement,string $className): array
    {
        $req=$this->getConnect()->query($statement);
        $datas=$req->fetchAll(PDO::FETCH_CLASS,$className);
        return $datas;
    }

    public function prepare(string $statement,string $className, array $values=[], bool $single=false)
    {
        $req=$this->getConnect()->prepare($statement);
        $req->execute($values);
        $req->setFetchMode(PDO::FETCH_CLASS,$className);
        if ($single){
            $data=$req->fetch();
        }
        else{
            $data=$req->fetchAll();
        }
        return $data;
    }

    public function exec(string $statement,array $values) :bool | int
    {
        $req=$this->getConnect()->prepare($statement);
        $result=$req->execute($values);
        return $result;
    }
}