<?php
namespace Editiel98;

class App{

    private $route;

    public function run()
    {
        
        $uri=$_SERVER['REQUEST_URI'];
        if(strlen($uri)>1&& $uri[-1]=='/'){
            var_dump(substr($uri,0,-1));
            header('Location: ' . substr($uri,0,-1));
            header('HTTP/1.1 301 Moved Permanently');
            exit();
        }
        $routing=$this->decodeURI($uri);
        $firstRoute=$routing[0][0];
        switch($firstRoute){
            case '' : //Home
                $this->route='home';
                break;
            case 'parametres': //parameters
                $this->route='parameters';
                break;
            default : //home
               $this->route='home';
        }
        $test=new \App\Index();
        $test->render();
    }

    private function decodeURI($uri)
    {
        //remove first /
        $uri=substr($uri,1);
        $params=explode('?',$uri);
        if(!empty($params[1])){
            $paramsList=explode('&',$params[1]);
        }
        else
        $paramsList=[];
        $pages=explode('/',$params[0]);
        return [$pages,$paramsList];

    }
}