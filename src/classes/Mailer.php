<?php
namespace Editiel98;

use Exception;

/**
 * Mailer Class : Send an Email
 */
class Mailer
{
    private string $adminMail;
    private SmartyMKD $smarty;
    
    public function __construct()
    {
        $this->loadParams();
        $this->smarty=new SmartyMKD();
    }
    
    private function loadParams()
    {
        try{
            $config= simplexml_load_file(__DIR__ . '/../config.xml');
            var_dump($config);
            if ($config===false){
                throw new Exception('Impossible de lire les credentials');
            }
            if($config->general->env=='debug'){
                ini_set('SMTP','192.168.1.10');
                echo "passe";
            }
            $this->adminMail=$config->mail->admin;
            var_dump(gettype($this->adminMail),$this->adminMail);
          
        }
        catch (Exception $e)
        {
            $errCode=$e->getCode();
            $errMessage=$e->getMessage();
            throw new Exception('Impossible de lire les credentials');
        }
    }

    /**
     * Function SendMail : 
     * Send an email with all  infos filled
     *
     * @param string $to
     * @param string $from
     * @param string $subject
     * @param string $message
     * @param boolean|null $html
     * @return boolean
     */
    private function sendMail(string $to, string $from, string $subject, string $message,?bool $html=false): bool
    {
        $headers=[
            "From"=>$from,
            "Reply-To"=>$from,
        ];
        if($html){
            $headers['Content-Type']='text/html; charset=utf-8';
        }
        return mail($to,$subject,$message,$headers);
    }
    /**
     * Send a text mail to the admin
     *
     * @param string $from
     * @param string $subject
     * @param string $message
     * @return boolean
     */
    public function sendMailToAdmin(string $from,string $subject,string $message): bool
    {
        $MessageMail=wordwrap($message,70,'\r\n');
        return $this->sendMail($this->adminMail,$from,$subject,$MessageMail,false);
    }

    /**
     * Send an HTML mail to the admin
     *
     * @param string $from mail sender
     * @param string $subject subject of mail
     * @param array $values to put in template
     * @param string $template HTML template of the mail
     * @return boolean
     */
    public function sendHTMLMailToAdmin(string $from,string $subject,array $values, string $template): bool
    {
        $MailTemplate='mail/' . $template . '.tpl';
        foreach($values as $k=>$v){
            $this->smarty->assign($k,$v);
        }
        $content=$this->smarty->fetch($MailTemplate);
        return $this->sendMail($this->adminMail,$from,$subject,$content,true);
    }

    /**
     * Send a text mail to one user from admin
     *
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return boolean
     */
    public function sendMailToUser(string $to,string $subject, string $message): bool
    {
        $MessageMail=wordwrap($message,70,'\r\n');
        return $this->sendMail($to,$subject,$MessageMail,false);
    }

    /**
     * Send a HTML mail rom admin to user
     *
     * @param string $to
     * @param string $subject
     * @param array $values
     * @param string $template
     * @return boolean
     */
    public function sendHTMLMailToUser(string $to,string $subject,array $values, string $template): bool
    {
        $MailTemplate='mail/' . $template . '.tpl';
        foreach($values as $k=>$v){
            $this->smarty->assign($k,$v);
        }
        $content=$this->smarty->fetch($MailTemplate);
        return $this->sendMail($to,$this->adminMail,$subject,$content,true);
    }
}