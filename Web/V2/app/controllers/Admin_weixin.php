<?php
if (!defined('IN_DLC')) exit ('No direct script access allowed');
/**
*
* @package  management    
* @author       
* @copyright    
* @license      
* @link         
* @since       Version 1.0
* @filesource
*/
class Admin_weixin extends Admin_Controller {
	/**
	 * 构造函数
	 *
	 * @access  public
	 * @return  void
	 */
	public function __construct() 
	{
		parent :: __construct();
	}

	public function menu($id){
		$this->load->config('wx_config');
		$appid = $this->config->item('JSAPI_appid');
		$secret = $this->config->item('JSAPI_appsecret');
		$this->load->library('jssdk', array($appid, $secret));		
		
		$ajax = $this->input->post('ajax');
		if($ajax){
			$menus = $this->input->post('menus');
			
			$newmenus = array('button' => array());
			foreach($menus['selfmenu_info']['button'] as $menu){
				if($menu['_delete'] || empty($menu['name']))continue;
				if(count($menu['sub_button']['list'])){
					$newmenus['button'][] = array(
						'name' => $menu['name'],
						'sub_button' => array()
					);
					$i = count($newmenus['button']) - 1;
					$j = 0;
					foreach($menu['sub_button']['list'] as $submenu){
						if($submenu['_delete'] || empty($submenu['name']))continue;
						if($submenu['type'] == 'view'){
							$newmenus['button'][$i]['sub_button'][] = array(
								'name' => $submenu['name'],								
								'type' => $submenu['type'],
								'url' => $submenu['url'],
							);
						}else{
							$newmenus['button'][$i]['sub_button'][] = array(
								'name' => $submenu['name'],
								'type' => $submenu['type'],
								'key' => $submenu['key'],
							);
						}
						$j ++;
					}
					if($j == 0){
						unset($newmenus['button'][$i]['sub_button']);
						if($menu['type'] == 'view'){
							$newmenus['button'][$i] = array(
								'name' => $menu['name'],
								'type' => $menu['type'],
								'url' => $menu['url'],
							);
						}else{
							$newmenus['button'][$i] = array(
								'name' => $menu['name'],
								'type' => $menu['type'],
								'key' => $menu['key'],
							);
						}
					}
				}else{
					if($menu['type'] == 'view'){
						$newmenus['button'][] = array(
							'name' => $menu['name'],
							'type' => $menu['type'],
							'url' => $menu['url'],
						);
					}else{
						$newmenus['button'][] = array(
							'name' => $menu['name'],
							'type' => $menu['type'],
							'key' => $menu['key'],
						);
					}
				}
			}
			$result = $this->jssdk->menu_create($newmenus);
			die('{"status":'.($result['errcode'] ? 0 : 1).'}');
		}
		
		$menus = $this->jssdk->get_current_selfmenu_info();
		$this->assign('menus', $menus);
		$this->display('bguser/weixin_menu.html');
	}
}