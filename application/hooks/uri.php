<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 

class RelativeUrlHook {

  private $exec;

  public function __construct() {
    $ci = get_instance();
    $controller_name = get_class($ci); 
	$is_admin = @$ci->config->item('is_admin');
	
    if($is_admin==true) {
    	$this->exec = false;
    } else {
    	$this->exec = true;
    }
  }

  public function rewrite_base_url() {
    if($this->exec) {
    	$n = count(explode('/', uri_string())) - 2;
 
		$str = '';
		for ($i=0; $i < $n; $i++)
		{ 
			$str .= '../';
		}
	 
		$CI =& get_instance();
		$CI->config->set_item('base_url', $str);
    }
  }
} 

 
/* End of file uri.php */
/* Location: application/hooks/uri.php */