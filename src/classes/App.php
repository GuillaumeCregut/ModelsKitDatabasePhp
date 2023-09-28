<?php
namespace Editiel98;

class App{
    public function run()
    {
        $uri=$_SERVER['REQUEST_URI'];
        var_dump($uri);
        if(!empty($uri)&& $uri[-1]=='/'){
            header('Location: ' . substr($uri,0,-1));
            header('HTTP/1.1 301 Moved Permanently');
            exit();
        }
        echo "Toto";
    }
}