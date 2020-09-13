<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Rest.php';

class Api extends CI_Controller {

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
	public function __construct()
    {
        parent::__construct();
        $this->objRest = new Rest();
    }

	public function getAllProducts(){
		if($this->objRest->request != 'GET'){
			$this->objRest->throwError(REQUEST_METHOD_NOT_VALID, 'Request Method is not valid.');
		}

		$queryData = [];
	    $queryData = $this->db->get_where('tbl_product')->result();
		if(!empty($queryData)){
	        foreach ($queryData as $key => $value) {
	        	$tbl_product_images_query = $this->db->get_where('tbl_product_images',['product_id'=>$value->id])->result();
	        	if(!empty($tbl_product_images_query)){
		        	$data = [];
		        	foreach ($tbl_product_images_query as $key1 => $value1) {
		        		$data[] = $value1->image_path;
		        	}
		        	$value->image_path = $data;
	        	}
	        }
		}

        if(empty($queryData)){
            $this->objRest->returnResponse(SUCCESS_RESPONSE, 'Product details not found');
        }
        $this->objRest->returnResponse(SUCCESS_RESPONSE, $queryData);
    }

    public function addToCart(){
    	if($this->objRest->request != 'POST'){
			$this->objRest->throwError(REQUEST_METHOD_NOT_VALID, 'Request Method is not valid.');
		}

        $data = [];

        $requiredParameters = ['user_id'];
        foreach ($requiredParameters as $key => $value) {
            if(!isset($this->objRest->param[$value])){
                $this->objRest->returnResponse(UNPROCESSABLE_ENTITY, 'Request parameter ' .$value. ' missing');
            }
        }
        $data['user_id'] = $this->objRest->validateParameter('user_id', $this->objRest->param['user_id'], INTEGER, true);

        if(isset($this->objRest->param['products'])){
        	$products = $this->objRest->validateParameter('products', $this->objRest->param['products'], 'ARRAY', true);
        	foreach ($products as $key => $value) {
		        $data['product_id'][$key] = $this->objRest->validateParameter('product_id', $value['product_id'], INTEGER, true);
		        $data['quantity'][$key] = $this->objRest->validateParameter('quantity', $value['quantity'], INTEGER, true);
        	}
        } else {
        	$this->objRest->returnResponse(UNPROCESSABLE_ENTITY, 'Request parameter products missing');
        }

        foreach ($data['product_id'] as $key => $value) {
        	$product_id 	= $data['product_id'][$key];
        	$quantity 		= $data['quantity'][$key];
        	
			$queryData = $this->db->select('id')->where('user_id', $data['user_id'])->where('product_id', $product_id)->from('tbl_cart')->count_all_results();

			$cartData = [];
			$cartData = ['user_id' => $data['user_id'], 'product_id'=> $product_id, 'quantity' => $quantity];
			if($queryData>0){
				//update here
				$this->db->where('user_id', $data['user_id']);
				$this->db->where('product_id', $product_id);
				$this->db->update('tbl_cart', $cartData);
			}
			else {
				//insert here
				$this->db->insert('tbl_cart', $cartData);
			}
        }

        $message = "User cart updated successfully.";
        $this->objRest->returnResponse(SUCCESS_RESPONSE, $message);
    }

    public function getCart(){
    	if($this->objRest->request != 'GET'){
			$this->objRest->throwError(REQUEST_METHOD_NOT_VALID, 'Request Method is not valid.');
		}

        $requiredParameters = ['id'];
        foreach ($requiredParameters as $key => $value) {
            if(!isset($this->objRest->param[$value])){
                $this->objRest->returnResponse(UNPROCESSABLE_ENTITY, 'Request parameter ' .$value. ' missing');
            }
        }
        $id = $this->objRest->validateParameter('id', $this->objRest->param['id'], INTEGER, false);

        $queryData = [];
        $queryData = $this->db->get_where('tbl_cart', array('user_id' => $id))->result();
        if(!$queryData){
            $this->objRest->returnResponse(SUCCESS_RESPONSE, 'cart details not found');
        }
        $this->objRest->returnResponse(SUCCESS_RESPONSE, $queryData);
    }
}
