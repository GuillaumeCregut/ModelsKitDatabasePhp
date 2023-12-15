<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;
use Editiel98\DbException;

class DBManager extends Manager
{
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    
    public function getCurrentVersion(): string
    {
        $query="SELECT value FROM system_mkd WHERE name='version'";
        try{
           $data=$this->db->query($query);
           return $data[0]->value;

        } catch(DbException $e) {
           return 'Une erreur de lecture est survenue';
        }
        return '';
    }

    public function updateDb($datas)
    {
        $errors=[];
        //Pour chaque ligne (?) de l'objet XML reçu, on joue la requête, et si souci on sotck dans error
        //On start une transaction ?
        foreach($datas as $data) {
            try{

            } catch(DbException $e) {
                $error=[
                    $e->getdbMessage(),
                    $data->description,
                ];
                $errors[]=$error;
                //On rollBack ?
            }
        }
        //On commit la transaction ?
    }
}