<?php
/**
 * Class SmartyMKD
 * Use smarty with all datas configured
 */

namespace Editiel98;
require_once(dirname((__FILE__)).'/smarty/Smarty.class.php');

class SmartyMKD extends \Smarty{ 
   public function __construct()
   {
        parent::__construct();
        $templateDir=__DIR__ . '/../templates/';
        $this->template_dir=$templateDir;
       $this->compile_dir=__DIR__ . '/../templates_c/';
      // $this->config_dir='configs';
       //$this->cache_dir='cache/';
      // $this->caching=true;
       $this->assign('app_name','Models Kit Database'); 
       
   }

}
?>
