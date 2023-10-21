<?php
namespace Editiel98\Manager;

use Editiel98\App;
use Editiel98\Database\Database;
use Editiel98\DbException;

class StatsManager extends Manager
{
    public function __construct(Database $db)
    {
        $this->db=$db;
    }

    public function getStatPeriod(int $user)
    {
        $query='SELECT count(*) as count, periodName as name FROM all_info_model WHERE owner=:user AND state<>:state GROUP BY periodName';
        $values=[
            ':user'=>$user,
            ':state'=>App::STATE_LIKED
        ];
        try{
            return $this->db->prepare($query,null,$values);
        }catch(DbException $e){
            return [];
        }
    }

    public function getStatState(int $user)
    {
        $query='SELECT count(*) as count, s.name FROM all_info_model ai  INNER JOIN state s on ai.state=s.id WHERE ai.owner=:user GROUP BY ai.state';
        $values=[
            ':user'=>$user
        ];
        try{
            return $this->db->prepare($query,null,$values);
        }catch(DbException $e){
            return [];
        }
    }

    public function getStatCategory(int $user)
    {
        $query='SELECT count(*) as count, categoryName as name FROM all_info_model WHERE owner=:user AND state<>:state GROUP BY categoryName;';
        $values=[
            ':user'=>$user,
            ':state'=>App::STATE_LIKED
        ];
        try{
            return $this->db->prepare($query,null,$values);
        }catch(DbException $e){
            return [];
        }
    }

    public function getStatScale(int $user)
    {
        $query='SELECT count(*) as count, scaleName as name FROM all_info_model WHERE owner=:user AND state<>:state GROUP BY scaleName;';
        $values=[
            ':user'=>$user,
            ':state'=>App::STATE_LIKED
        ];
        try{
            return $this->db->prepare($query,null,$values);
        }catch(DbException $e){
            return [];
        }
    }

    public function getStatPrice(int $user)
    {
        $query='SELECT SUM(price) as sum FROM `all_info_model` WHERE owner=:user';
        $values=[
            ':user'=>$user
        ];
        try{
            return $this->db->prepare($query,null,$values);
        }catch(DbException $e){
            return [];
        }
    }

    public function getStatBrand(int $user)
    {
        $query='SELECT count(*) as count, brandName as name FROM all_info_model WHERE owner=:user AND state<>:state GROUP BY brandName';
        $values=[
            ':user'=>$user,
            ':state'=>App::STATE_LIKED
        ];
        try{
            return $this->db->prepare($query,null,$values);
        }catch(DbException $e){
            return [];
        }
    }

    public function getStatProvider(int $user)
    {
        $query='SELECT count(*) as count, providerName as name FROM all_info_model WHERE owner=:user GROUP BY provider';
        $values=[
            ':user'=>$user
        ];
        try{
            return $this->db->prepare($query,null,$values);
        }catch(DbException $e){
            return [];
        }
    }

}

/*
//Period
SELECT count(*) as count, periodName as name FROM all_info_model WHERE owner=? GROUP BY periodName
//state
'SELECT count(*) as count, s.name FROM all_info_model ai  INNER JOIN state s on ai.state=s.id WHERE ai.owner=? GROUP BY ai.state;
//type
SELECT count(*) as count, categoryName as name FROM all_info_model WHERE owner=? GROUP BY categoryName;
//Provider
SELECT count(*) as count, providerName as name FROM all_info_model WHERE owner=? GROUP BY provider;
//Scale
SELECT count(*) as count, scaleName as name FROM all_info_model WHERE owner=? GROUP BY scaleName;
//Price
SELECT SUM(price) as sum FROM `all_info_model` WHERE owner=?
//Brand
SELECT count(*) as count, brandName as name FROM all_info_model WHERE owner=? GROUP BY brandName
*/