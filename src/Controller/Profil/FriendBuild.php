<?php

namespace App\Controller\Profil;

use App\Controller\Error;
use Editiel98\Manager\SocialManager;
use Editiel98\Router\Controller;


class FriendBuild extends Controller
{
    public function render()
    {
        var_dump($_POST);
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        if (empty($_POST) || !isset($_POST['action'])) {
            $this->displayError();
        }
        switch ($_POST['action']) {
            case 'go':
                $this->displayPage();
                break;
            default:
                $this->displayError();
        }
    }

    private function displayPage()
    {
        if (!isset($_POST['id']) || intval($_POST['id']) === 0 || !isset($_POST['friend']) || intval($_POST['friend']) === 0) {
            $this->displayError();
        }
        $idModel = intval($_POST['id']);
        $idFriend = intval($_POST['friend']);
        $socialManager = new SocialManager($this->dbConnection);
        $models=$socialManager->getFriendModelDetails($idFriend,$idModel);
        $model=$models[0];
        var_dump($model);
        //get pictures
        $dirPictures=$model->pictures;
        $files=[];
        if($dirPictures){
            //Get pictures if there are
            $baseDir=dirname(dirname(dirname(__DIR__))) . '/public/';
            if(is_dir($baseDir . $dirPictures)){
                $scan=scandir($baseDir . $dirPictures);
                foreach($scan as $file){
                    if($file!=='.' && $file!=='..'){
                        $files[]=$dirPictures .'/' . $file;
                    }
                }
            }
        }
        var_dump($files);
        //get messages
        $messages=$socialManager->getModelMessages($idModel);
        var_dump($messages);

        //for debug
        $idFriend=14;

        if(!empty($files)){
            $this->smarty->assign('pictures',$files);
        }
        if($model->allow===1){
            $this->smarty->assign('allow',true);
        }
        if(!empty($messages)){
            $this->smarty->assign('messages',$messages);
        }
        $this->smarty->assign('model',$model);
        $this->smarty->assign('friend',$idFriend);
        $this->smarty->assign('profil', true);
        $this->smarty->assign('social_menu', true);
        $this->smarty->display('profil/friendbuild.tpl');
    }

    private function storeMessage()
    {
        //Do some stuff
        $this->displayPage();
    }

    private function displayError()
    {
        $page = new Error(404);
        $page->render();
        die();
    }
}
