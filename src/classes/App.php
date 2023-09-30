<?php
namespace Editiel98;

use App\Controller\Error;

class App{

    const ADMIN=5;
    const USER=1;
    const MODERATE=2;

    private string $route;
    private array $params;
    private array $subPages;
    public function run()
    {
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
}