<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function addProduct()
	{
		if(!empty($this->input->post())){
			$postData = $this->input->post();
			extract($postData);
			$error=array();
			$extension=array("jpeg","jpg","png");
			$filePathArr = [];
			foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) {
			    $file_name=$_FILES["files"]["name"][$key];
			    $file_tmp=$_FILES["files"]["tmp_name"][$key];
			    $file_path=BASEPATH."../img_gallery/".$file_name;
			    $ext=pathinfo($file_name,PATHINFO_EXTENSION);

			    if(in_array($ext,$extension)) {
			        if(!file_exists($file_path)) {
			            move_uploaded_file($file_tmp, $file_path);
			        }
			        else {
			            $basename=basename($file_name,$ext);
			            $file_name=$fileBasename.time().".".$ext;
			            $file_path=BASEPATH."../img_gallery/".$file_name;
			            move_uploaded_file($file_tmp, $file_path);
			        }
			        $filePathArr[$file_name] = $file_path;
			    }
			    else {
			        array_push($error,"$file_name, ");
			    }
			}

			$this->db->insert('tbl_product',$postData);
			$lastInsertId = $this->db->insert_id();

			foreach ($filePathArr as $key => $value) {
				$arr = [
					'product_id' => $lastInsertId,
					'image_name' => $key,
					'image_path' => $value
				];
				$this->db->insert('tbl_product_images',$arr);
			}
		}
		$this->load->view('backend/add-product-view');
	}
}
