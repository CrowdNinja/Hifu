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
class Admin_media extends Admin_Controller
{
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */

    private $role_type = array(0 => '系统', 1 => '代理商', 2 => '商家');
    public function __construct()
    {
        parent:: __construct();
    }

    public function index()
    {
        $page = $this->input->get('page');
        //$this->assign('page',$page?:1);
        $pagesize = $this->input->get('pagesize');

        $setting = $this->setting_mdl->get('setting');
        $slide_images = $this->_getlist('media', '*', 'type=0');
        $tutorial_videos = $this->_getlist('media', '*', 'type=1');

        $this->assign('slide_images', $slide_images);
        $this->assign('tutorial_videos', $tutorial_videos);
		
        $this->display('media/index.html');
    }

    public function uploadMedia()
    {
      $filename = $_FILES['media']['name'];
      $type = $_POST['type'];
      $uploadOk = 1;
      $mediaFileType = pathinfo($filename,PATHINFO_EXTENSION);
      $time = date('YmdHis');
      $location = "upload/media/".$time.".".$mediaFileType;
      $path = "upload/media/";
      /* Valid Extensions */
      if ($type==0)
        $valid_extensions = array("jpg","jpeg","png");
      else 
        $valid_extensions = array("mp4","webm","ogv");
      /* Check file extension */
      if( !in_array(strtolower($mediaFileType),$valid_extensions) ) {
        $uploadOk = 0;
      }
      if($uploadOk == 0){
        die('{"status":-1}');
      }else{
      /* Upload file */
      // echo $_FILES['image']['tmp_name'];
        if(move_uploaded_file($_FILES['media']['tmp_name'],$location)){
            $this->db->insert('media', ['url'=>$location, 'type' => $type, 'filename'=>$filename]);
            $media_id = $this->db->insert_id();
            $result = ['status' => 1, 'url' => base_url($location), 'id' =>$media_id ];
            die(json_encode($result));
        }else{
            die('{"status":0}');
        }
      }
    }

    public function deleteMedia()
    {
        $post = $this->input->post();
        if (!empty($post)) {
            $this->db->delete('media', 'id='.$post['id']);
        }
        die(json_encode([
            'status'=>1
        ]));
    }

    
    //获取总平台创建的角色
    public function get_admin_role(){
        $list=$this->_getlist('sys_role','id,title','aid=1');
        die(json_encode(['data'=>$list]));
    }
}