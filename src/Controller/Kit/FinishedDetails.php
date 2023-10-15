<?php
namespace App\Controller\Kit;

use App\Controller\Error;
use Editiel98\Manager\MessageManager;
use Editiel98\Manager\ModelManager;
use Editiel98\Router\Controller;


class FinishedDetails extends Controller
{
    private object $model;
    private array $messages=[];
    private array $files=[];
    public function render()
    {
        if (!$this->isConnected || !isset($_GET['id'])) {
            //Render antoher page and die
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        //get id from GET
        if (!$this->isConnected || !isset($_GET['id'])) {
            //Render antoher page and die
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $id=intval($_GET['id']);
        if($id===0){
            $page=new Error('404', 'le kit n\'existe pas');
            $page->render();
            die();
        }
        //Get model
        $modelManager=new ModelManager($this->dbConnection);
        $model=$modelManager->getOneFullById($id,$this->userId);
        if(!$model){
            $page=new Error('404', 'le kit n\'existe pas');
            $page->render();
            die();
        }
        $this->model=$model;
        $dirPictures=$model->pictures;
        if($dirPictures){
            //Get pictures if there are
            $baseDir=dirname(dirname(dirname(__DIR__))) . '/public/';
            $scan=scandir($baseDir . $dirPictures);
            foreach($scan as $file){
                if($file!=='.' && $file!=='..'){
                    $this->files[]=$dirPictures .'/' . $file;
                }
            }
        }
        //get messages
        $messageManager=new MessageManager($this->dbConnection);
        $messages=$messageManager->getMessagesForModel($id);
        if($messages){
            if(!empty($messages)){
                $this->formatAvatar($messages);
            }
        }
        $this->displayPage();
    }

    private function displayPage()
    {
        $this->smarty->assign('kits', true);
        $this->smarty->assign('model',$this->model);
        if(!empty($this->messages)){
            $this->smarty->assign('messages',$this->messages);
        }
        if(!empty($this->files)){
            $this->smarty->assign('pictures',$this->files);
        }
        $this->smarty->display('kit/finishedDetails.tpl');
    }

    private function formatAvatar(array $messages)
    {
        foreach($messages as $message){
            $id=$message->userId;
            if( $message->avatar){
                $baseUrl='assets/uploads/users/'. $id . '/' . $message->avatar;
                $message->avatar=$baseUrl;
            }
            $this->messages[]=$message;
        }
    }
}