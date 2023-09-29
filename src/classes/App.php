<?php
namespace Editiel98;

class App{

    private string $route;
    private array $params;
    private array $subPages;
    public function run()
    {
        
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
                $this->route='Index';
                $classPage='\\App\Index';
                break;
            case 'parametres': //parameters
                $this->route='parameters';
                break;
            default : //home
               $this->route='Index';
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