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
		$this->db->select('*')
         ->from('tbl_product as t1')
         ->join('tbl_product_images as t2', 't1.id = t2.product_id');
		$query = $this->db->get();

        $queryData = $query->result();

        if(!$queryData){
            $this->objRest->returnResponse(SUCCESS_RESPONSE, 'Product details not found');
        }
        $this->objRest->returnResponse(SUCCESS_RESPONSE, $queryData);
    }

    public function addToCart(){
        
    }

    public function getCart(){
        
    }
}
