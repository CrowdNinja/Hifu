<?php if ( ! defined('IN_DLC')) exit('No direct script access allowed');
/**
 *  
 *
 * @package     admin.models
 * @subpackage  Models
 * @category    Models
 * @author      
 * @link         
 */
class Setting_mdl extends DLC_Model
{
	
	/**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
	private $prefix = 'setting_';
	public function __construct()
	{
		parent::__construct();	
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => ''));
	}
	
	
	public function get($key = ''){
		$row = $this->cache->get($this->prefix.$key);
		if($row){
			//
		}else{
			$row = $this->_getrow('setting', '*', "key='".$key."'");
			$this->cache->save($this->prefix.$key, $row, 0);
		}
		// $row = $this->_getrow('setting', '*', "key='".$key."'");
		// $this->cache->save($this->prefix.$key, $row, 0);
		$result = json_decode($row['val'], true);
		if($row['type'] == '1'){
			if(count($result) > 1){
				foreach($result as &$v){
					$v = explode("\n", str_replace("\r", "", $v));
				}
				unset($v);
				return $result;
			}
			return explode("\n", str_replace("\r", "", $result[0]));
		}
		return $result;
	}
	
	//获取手续费、平台提成等
	public function sysmoney($money, $key = 'cashfee'){
		$config = $this->setting_mdl->get('config');
		$rule = $config[$key];
		if($rule){
			if(strpos($rule, '%') === false){
				$sysmoney = $rule;	
			}else{
				$sysmoney = floatval($money) * floatval(str_replace('%', '', $rule)) / 100;	
			}
		}
		return number_format(floatval($sysmoney), 2);
	}
}
