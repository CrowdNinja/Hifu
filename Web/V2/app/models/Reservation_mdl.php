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
class Reservation_mdl extends DLC_Model
{
	
	/**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
	public function __construct()
	{
		parent::__construct();	
	}

  public function update($data, $reserv_id)
  {
    $this->db->update('reservation', $data, 'id='.$reserv_id);
  }
}

/* End of file admin_mdl.php */
/* Location: ./admin/models/admin_mdl.php */