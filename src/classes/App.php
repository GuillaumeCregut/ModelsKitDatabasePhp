<?php
namespace Editiel98;

use App\Controller\Error;
use Editiel98\Event\Emitter;
use Editiel98\Logger\ErrorLogger;
use Editiel98\Logger\WarnLogger;

class App{

    const ADMIN=5;
    const USER=1;
    const MODERATE=2;

    private string $route;
    private array $params;
    private array $subPages;
    private Emitter $emitter;

    public function run()
    {
        $this->setEmitter();
        // var_dump($_SERVER['REQUEST_METHOD']);
        $uri=$_SERVER['REQUEST_URI'];
        if(strlen($uri)>1&& $uri[-1]=='/'){
            var_dump(substr($uri,0,-1));
            header('Location: ' . substr($uri,0,-1));
            header('HTTP/1.1 301 Moved Permanently');
            exit();
        }
        $firstRoute=$this->decodeURI($uri);
        switch($firstRoute){
            case '' : //Home
                $this->route='Home';
                //$classPage='\\App\Index';
                break;
            case 'login':
                $this->route='Login';
                break;
            case 'logout':
                $this->route='Logout';
                break;
            case 'parametres': //parameters
                $this->route='parameters';
                break;
            case 'rgpd':
                $this->route='rgpd';
                break;
            case 'signup':
                $this->route='Signup';
                break;
            case 'test':
                $this->route="Test";
                break;
            default : //home
               $page=new Error('404');
               $page->render();
               die();
        }
        $classPage='\\App\\Controller\\' . $this->route;
        $page=new $classPage($this->subPages,$this->params);
        $page->render();
    }

    private function decodeURI($uri) : string
    {
        //remove first /
        $uri=substr($uri,1);
        $params=explode('?',$uri);
        if(!empty($params[1])){
            $paramsList=explode('&',$params[1]);
        }
        else
        $paramsList=[];
        $this->params= $paramsList;
        $pages=explode('/',$params[0]);
        $subPages=explode('_',$pages[0]);
        $this->subPages=array_slice($subPages,1);
        return $subPages[0];

    }

    private function setEmitter()
    {
        $this->emitter=Emitter::getInstance();
        $this->emitter->on(Emitter::DATABASE_ERROR,function($message){
            $logger=new ErrorLogger();
            if($logger->storeToFile($message)){
                $logger=null;
            }
        });
        $this->emitter->on(Emitter::USER_SUBSCRIBED,function ($message){
            $mail=new Mailer();
            $mail->sendMailToAdmin('no-reply@MKD.local','Nouvel utilisateur',$message);
        });
        $this->emitter->on(Emitter::MAIL_ERROR,function ($to){
            $logger=new WarnLogger();
            $message="L'envoi du mail à " . $to . ' a échoué';
            if($logger->storeToFile($message)){
                $logger=null;
            }
        });
        /*$this->emitter->on('Comment.created',function ($firstname, $lastname){
            echo $firstname . 'a poster un commentaire'; 
        });
        $this->emitter->on('Comment.created',function ($firstname, $lastname){
            $email=new Mailer();
            $email->sendMailToAdmin('test@editiel.local','Test Emitter','Ceci est un test'); 
        });
        */
    }
}