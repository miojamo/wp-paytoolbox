<?php

class WpPaytoolbox{

	private $apiUrl = WPPTB_API_URL;

	private $client;

	private $channel = 'DEFAULT';

	public function __construct(){

		$this->client = new GuzzleHttp\Client([
			// 'base_uri' => $this->apiUrl,
		    'timeout'  => 5.0,
		]);

	}
	
	/**
	* Called by add_action('plugins_loaded'....
	**/
	public function init(){

		add_shortcode("wpptb-categories", array($this, 'doListCategories'));

    	wp_enqueue_style( 'wpptb-style', plugins_url('style.css', __FILE__)  );

		$this->login();

	}

	public function doListCategories(){
		$category = @$_GET['view'];
		$product  = @$_GET['product'];

		if( !empty($category))     $this->printCategoryProducts($category);
		elseif( ! empty($product)) $this->printProduct($product);
		else 					   $this->printAllCategories();
	}

	private function printProduct($product){

		// This is used by function ..._get_category()
		$GLOBALS['wpptb-product'] = $this->getDataFromEndpoint("/products/".$product . '?channel=' . $this->channel);
		
		$this->showPage('product');

	}

	private function printCategoryProducts($category){

		$prods = $this->getDataFromEndpoint("/taxon-products/".$category . '?channel=' . $this->channel);
		$GLOBALS['wpptb-category-products'] = $prods['items']; // This is used by function ..._get_category()

		$this->showPage('category-products');

	}

	private function printAllCategories(){

		$categories = $this->getDataFromEndpoint("/taxons");

		// This is used by function *get_all_categories()
		$GLOBALS['wpptb-all-categories'] = $this->mapMultiDimensionalToSimpleArray($categories); 
		
		$this->showPage('categories');

	}

	/**
	* Load template and show page.
	**/
	private function showPage($templateName){
		$theme_file = get_template_directory() . DIRECTORY_SEPARATOR . 'wpptb-'.$templateName.'.php';
		$default_file = 'templates' . DIRECTORY_SEPARATOR . $templateName . '.php';
		include file_exists($theme_file) ? $theme_file : $default_file;
	}

	private function mapMultiDimensionalToSimpleArray($cats){
		$out = [];
		foreach ($cats as $row) {
			$out[] = [
				'name' => $row->name,
				'slug' => $row->slug,
				'code' => $row->code,
			];

			if(! empty($row->children)){
				$out = array_merge($out, $this->mapMultiDimensionalToSimpleArray($row->children) );
			}

		}

		return $out;

	}


	private function getDataFromEndpoint($endpoint, $method = 'GET', $params = []){

		$token = $_SESSION['wpptb-token'];

		$headers = [
			'Authorization' => 'Bearer ' . $token
		];
		$response = $this->client->request($method, $this->apiUrl . $endpoint, [
		//	'body' =>  implode("&", $params)
//			'json' => []
			'form_params' => $params,
		]);

		$json_resp = $response->getBody()->getContents();

		if($response->getStatusCode() !='200'){
			throw new Exception("Request failed, status:" . $response->getStatusCode() );
		}

		return (array)json_decode($json_resp);

	}

	private function login(){
		
		if(! isset($_SESSION['wpptb-token']) || empty($_SESSION['wpptb-token']) ){

			$resp = $this->getDataFromEndpoint('/login_check', 'POST', [
				'_username' => WPPTB_API_USERNAME,
				'_password' => WPPTB_API_PASSWORD,
			]);
			$_SESSION['wpptb-token'] = $resp['token'];

		} 
	}

}