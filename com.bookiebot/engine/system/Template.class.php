<?php

if (!defined("APP")) {
	die("Dont have Access");
}


/**
 * This class extends Smarty and manipulates template rendering
 */
class Template extends Smarty {
	
	  /**
	   * Gets global variable config to determine which template is dir is default
	   * @return void
	   */
      function __construct() {
			  global $config;
              parent::__construct();
              $this->template_dir = SKIN_DIR;
              $this->compile_dir  = ENGINE_DIR . 'smarty/System/templates_c/';
              $this->config_dir   = ENGINE_DIR . 'smarty/System/configs/';
              $this->cache_dir    = ENGINE_DIR . 'smarty/System/cache/';
			  
              $this->caching = 0;
              $this->assign('THEME', "/_media");
        }
        
        

	
	
	
}


?>