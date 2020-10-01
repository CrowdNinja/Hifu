<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require(BASEPATH.'../app/libraries/Smarty-3.1.19/libs/Smarty.class.php');
                           
class Ci_smarty extends Smarty
{
    protected $ci;
     
    public function __construct()
    {
        parent::__construct();
        $this->ci = & get_instance();
        $this->ci->load->config('smarty'); 
        $this->cache_lifetime  = $this->ci->config->item('cache_lifetime');
        $this->caching          = $this->ci->config->item('caching');
        $this->template_dir    = $this->ci->config->item('template_dir');
        $this->compile_dir     = $this->ci->config->item('compile_dir');
        $this->cache_dir       = $this->ci->config->item('cache_dir');
        $this->use_sub_dirs    = $this->ci->config->item('use_sub_dirs');
        $this->left_delimiter  = $this->ci->config->item('left_delimiter');
        $this->right_delimiter = $this->ci->config->item('right_delimiter');
        if ( method_exists( $this, 'assignByRef') )
        {
            $ci =& get_instance();
            $this->assignByRef("ci", $ci);
        }
    }
}