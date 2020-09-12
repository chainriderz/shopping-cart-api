<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller {

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
	public function index()
	{
		$curlRes =  $this->callApi('getAllProducts');
        $data = json_decode($curlRes);
        $allProductData = $data->response->result;
		$allProductName = array_column($allProductData, "name", "product_id");
		$allProductPrice = array_column($allProductData, "price", "product_id");
		$allProductImages = [];
		foreach ($allProductData as $key => $value) {
			$allProductImages[$value->product_id][] = $value->image_path;
		}

		$this->load->view('frontend/index', ['allProductName' => $allProductName, 'allProductPrice'=> $allProductPrice, 'allProductImages'=>$allProductImages]);
	}

	public function callApi($apiName, $method = 'post', $data = []){
			$methodeFlag = ($method == 'post')?true:false;
            // kvstore API url
            $url = 'http://localhost:8080/shopping-cart-api/index.php/Api/'.$apiName;
            // Initializes a new cURL session
            $curl = curl_init($url);
            // 1. Set the CURLOPT_RETURNTRANSFER option to true
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');

            // 2. Set the CURLOPT_POST option to true for POST request
            curl_setopt($curl, CURLOPT_POST, $methodeFlag);
            if(empty($data)){
            	$data = ['list' => true];
            }
            // 3. Set the request data as JSON using json_encode function
            curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));

            // 4. Set custom headers for RapidAPI Auth and Content-Type header
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
              'Content-Type: application/json'
            ]);
            // Execute cURL request with all previous settings
            $response = curl_exec($curl);

            // Close cURL session
            curl_close($curl);

            return $response;
        }
}
