<?php
if (!defined('IN_DLC')) exit ('No direct script access allowed');

class Index extends SM_Controller {

	public function __construct() 
	{
		parent :: __construct();
	}

	public function qrcode(){
		$get = $this->input->get();
		$text = $get['text'];
		$type = checknull($get['type'], 'string');
        $url = concaturl($get['url']);
		require_once(APPPATH."libraries/phpqrcode.php");
		$errorCorrectionLevel = "L";
		$matrixPointSize = "8";
		ob_clean();//这个一定要加上，清除缓冲区
		if($type == 'string'){
			ob_start();
		}
		QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 4, false, $get['colors'], $get['qrcodecolors']);
		if($type == 'string' && $text){
			$image = ob_get_contents();
			ob_end_clean();
			
			if($text){
				$im = imagecreatefromstring($image);
				$width = imagesx($im);
				$height = imagesy($im);
				$newimg = imagecreatetruecolor($width, $height + 20);
				//$newbg = imagecolorallocatealpha($newimg, 0, 0, 0, 127);
				//imagealphablending($newimg, false);
				//imagefill($newimg, 0, 0, $newbg);
				imagefill($newimg, 0, 0, imagecolorallocate($newimg, 255, 255, 255));//白色背景
				imagecopyresampled($newimg, $im, 0, 0, 0, 0, $width, $height, $width, $height);
				$fontfile = BASEPATH.'fonts/texb.ttf';
				$fontinfo = imagettfbbox(18, 0, $fontfile, $text);
				$fontwidth = abs($fontinfo[4] - $fontinfo[0]);
				//$fontheight = abs($fontinfo[5] - $fontinfo[1]);
				imagefttext($newimg, 18, 0, floor(($width - $fontwidth) / 2), $height, imagecolorallocate($newimg, 0, 0, 0), $fontfile, $text);
				imagesavealpha($newimg, true);
				ob_start();
				imagepng($newimg);
				$image = ob_get_contents();
				//ob_end_clean();
			}
			return $image;
		}
	}
}