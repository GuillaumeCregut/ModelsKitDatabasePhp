<?php
namespace App\Controller;

use Editiel98\Auth\DbAuth;
use Editiel98\Event\Emitter;
use Editiel98\Mailer;
use Editiel98\Router\Controller;
use Exception;

class  Signup extends Controller
{
    public function render()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['firstname'])){
                $firstname= htmlspecialchars($_POST['firstname'], ENT_NOQUOTES, 'UTF-8');
            }else{
                $firstname='';
            }
            if(isset($_POST['lastname'])){
                $lastname= htmlspecialchars($_POST['lastname'], ENT_NOQUOTES, 'UTF-8');
            }else{
                $lastname='';
            }
            if(isset($_POST['email'])){
                $email=htmlspecialchars($_POST['email'], ENT_NOQUOTES, 'UTF-8');
            }else{
                $email='';
            }
            if(isset($_POST['login'])){
                $login=htmlspecialchars($_POST['login'], ENT_NOQUOTES, 'UTF-8');
            }else{
                $login='';
            }
            if(isset($_POST['password'])){
                $pass=htmlspecialchars($_POST['password'], ENT_NOQUOTES, 'UTF-8');
            }else{
                $pass='';
            }
            if(($login==='')||($pass==='')||($firstname==='')||($lastname==='')||($email==='')){
                $this->smarty->assign('error','Veuillez remplir tous les champs, merci.');
            }
            else{
                try{
                    $auth = new DbAuth();
                    $isOK=$auth->signUp($login,$email,$firstname,$lastname,$pass);
                    if($isOK){
                        $this->smarty->assign('success',true);
                    }
                    else{
                        $this->smarty->assign('error',"Votre compte n'a pas été enregistré. Veuillez contacter l'administrateur");
                    }
                    $emitter=Emitter::getInstance();
                    $emitter->emit(Emitter::USER_SUBSCRIBED,"Un nouvel utilisateur s'est inscrit");
                    $mailer=new Mailer(); 
                    $values=[
                        'firstname'=>$firstname,
                        'lastname'=>$lastname
                    ];
                    $mailer->sendHTMLMailToUser($email,'votre inscription à Model Kits Database',$values,'signup');
                }
                catch(Exception $e){
                    $errPage=new Error('500',$e->getMessage());
                    $errPage->render();
                    die();
                }
            }
        }
        $this->smarty->display('signup.tpl');
    }
}