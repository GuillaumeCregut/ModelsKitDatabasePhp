<?php

namespace App\Controller\Kit;

trait TraitListKit
{
    private function makeSearch(string $searchParam): array
    {
        $key='';
        $sort='asc';
        switch ($searchParam) {
            case 'name':
                $key='modelName';
                break;
            case 'scale':
                $key='scaleName';
                break;
            case 'builder':
                $key='builderName';
                break;
            case 'brand':
                $key='brandName';
                break;
        }
        if(!empty($_GET['by'])){
            if($_GET['by']==='desc') {
                $sort='desc';
            }
        }
        if($key!=='') {
            return [$key,$sort];
        } 
        return [];
    }
}
