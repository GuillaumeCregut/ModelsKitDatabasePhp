<?php
namespace Editiel98\Api\Kit;

use Editiel98\Router\ApiController;

class AddPictures extends ApiController
{
    public function manage()
    {
        $var=$this->datas;
        $temp=[
            'Vars'=>$var,
            'Files'=>$_FILES,
            'POST'=>$_POST
        ];
        echo json_encode($temp);
    }
}