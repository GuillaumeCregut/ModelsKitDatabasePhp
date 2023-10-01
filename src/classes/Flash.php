<?php
namespace Editiel98;

class Flash
{
    private Session $session;
    const KEY='editielFlash';
    public function __construct()
    {
        $this->session=Factory::getSession();
    }

    public function setFlash(string $message, string $type )
    {
        $this->session->setKey(self::KEY,[
            'message'=>$message,
            'flashType'=>$type,
        ]);
    }

    public function getFlash():mixed{

        $flash=$this->session->getKey(self::KEY);
        if(!is_null($flash)){
            $this->session->deleteKey(self::KEY);
        }
        return $flash;
    }

    
  
}