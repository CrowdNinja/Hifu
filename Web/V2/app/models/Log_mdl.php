<?php if ( ! defined('IN_DLC')) exit('No direct script access allowed');
/**
 *  
 *
 * @package     后台操作日志
 * @subpackage  Models
 * @category    Models
 * @author      
 * @link         
 */
class Log_mdl extends DLC_Model
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

    /** 添加，插入
     * @param $table
     * @param $data
     * @return mixed
     */
	public function insert($table,$data){
	    $this->db->insert($table,$data);
	    $id=$this->db->insert_id();
        $this->creationLog($table,"C",$data);
        return $id;
    }

    /** 更新 修改
     * @param $table
     * @param $data
     * @param $where
     * @return mixed
     */
    public  function update($table,$data,$where){
	    $result=$this->db->update($table,$data,$where);
        $this->creationLog($table,"U",$data);
        return $result;
    }

    /** 删除 记录
     * @param $table
     * @param $where
     * @return mixed
     */
    public function delete($table,$where){
        $result=$this->db->delete($table,$where);
        $this->creationLog($table,"D",$where);
        return $result;
    }


    private function creationLog($table,$type,$memo){
        $sql=$this->db->last_query();
        $text="";
        if($memo){
            if($type=="D") {
               if(is_array($memo)){
                   foreach($memo as $k=>$v){
                       $text.=$k."=".$v.',';
                   }
               }else{
                   $text=$memo;
               }
            }else{
                foreach ($memo as $k => $v) {
                    if($v)$text .= $k . '->' . $v.',';
                }
            }
        }
        $text=trim($text,',');
        $data=[
            'aid'=>$_SESSION['aid']?:-1,
            'adminname'=>$_SESSION['adminname']?:'',
            'table'=>$table,
            'type'=>$type,
            'memo'=>$text,
            'sql'=>$sql,
            'ip'=>$this->input->ip_address(),
            'ctime'=>time()
        ];
        $this->db->insert('oper_log',$data);
    }
}
