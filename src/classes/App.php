<?php
namespace Editiel98;

use App\Controller\Error;
use Editiel98\Event\Emitter;
use Editiel98\Logger\ErrorLogger;
use Editiel98\Logger\WarnLogger;
use Exception;

class App{
    //user states
    const ADMIN=5;
    const USER=1;
    const MODERATE=2;
    //default admin ID
    const DEFAULT_ADMIN=1;
    const VERSION='1.4a';
    //Model States
    const STATE_STOCK=1;
    const STATE_WIP=2;
    const STATE_FINISHED=3;
    const STATE_LIKED=4;
    const STATE_BUY=5;

    private string $route;
    private array $params;
    private array $subPages;
    private Emitter $emitter;

    public function run()
    {
        $this->setEmitter();
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
            case 'admin':
                $this->route='Admin';
                break;
            case 'api':
                $this->route='Api';
                break;
            case 'forgot':
                $this->route='Forgot';
                break;
            case 'init':
                $this->route='Init';
                break;
            case 'kit':
                $this->route='Kit';
                break;
            case 'login':
                $this->route='Login';
                break;
            case 'logout':
                $this->route='Logout';
                break;
            case 'parametres': //parameters
                $this->route='Parameters';
                break;
            case'profil':
                $this->route='Profil';
                break;
            case 'recover':
                $this->route='Recover';
                break;
            case 'rgpd':
                $this->route='Rgpd';
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

    public static function getEnv() : string
    {
        try{
            $config= simplexml_load_file(dirname(__DIR__) . '/config.xml');
            if ($config===false){
                throw new Exception('Config not readable');
            }
            return $config->general->env;
        }
        catch (Exception $e)
        {
            throw new Exception('Config not readable');
        }
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
        $this->emitter->on(Emitter::USER_VALIDATED,function ($userMail, $values){
            $mail=new Mailer();
            $mail->sendHTMLMailToUser($userMail,'Votre compte est validé',$values,'validate' );
        });
        $this->emitter->on(Emitter::PDF_CREATOR,function($message){
            $logger=new ErrorLogger();
            if($logger->storeToFile($message)){
                $logger=null;
            }
        });
    }
}