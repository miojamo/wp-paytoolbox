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

		add_shortcode("wpptb-shop", array($this, 'doListCategories'));

    	wp_enqueue_style( 'wpptb-style', plugins_url('style.css', __FILE__)  );

		$this->login();

	}

	public function doListCategories(){
		$category = @$_GET['category'];
		$product  = @$_GET['product'];

		if( !empty($category))     $this->printCategoryProducts($category);
		elseif( ! empty($product)) $this->printProduct($product);
		else 					   $this->printAllCategories();
	}

	private function printProduct($product){

		// This is used by function ..._get_category()
		$api_product = $this->getDataFromEndpoint("/products/".$product . '?channel=' . $this->channel);

		$Product = new WpptbProduct();

		$price = "-";
		$currency = "";
		$thumb = "";

		//if( isset($product['variants']->{$product['code']}->price)){
		// Don't use isset() so we see if an error occured!
			$price = $api_product['variants']->{$api_product['code']}->price->current;
			$currency = $api_product['variants']->{$api_product['code']}->price->currency;
		//}


		if( ! empty($api_product['images'])){
			$img1 = current($api_product['images']);
			$thumb = WPPTB_BASE_URL . '/media/cache/product_medium/' . $img1->path;
		}

		$Product->setName($api_product['name']);
		$Product->setCurrency($currency);
		$Product->setPrice($price);
		$Product->setThumb($thumb);
		$Product->setDescription($api_product['description']);
		$Product->setImages($api_product['images']);
		$Product->setQuicksellUrl($api_product['quicksell']->checkout);

		$GLOBALS['wpptb-product'] = $Product;
		$this->showPage('product');
	}

	private function printCategoryProducts($category){

		$prods = $this->getDataFromEndpoint("/taxon-products/".$category . '?channel=' . $this->channel);
// print_r($prods['items']);

		$products = array();

		foreach ($prods['items'] as $row) {

			$first_img = current($row->images);
			$thumb = "";
			if( ! empty($first_img)){
				$thumb = WPPTB_BASE_URL . '/media/cache/product_medium/' . $first_img->path; 
			}

			$Product = new WpptbProduct();
			$Product->setName($row->name);
			$Product->setCode($row->code);
			$Product->setThumb($thumb);

			$products[] = $Product;

		}

		$GLOBALS['wpptb-category-products'] = $products; // This is used by function ..._get_category()

		$this->showPage('category-products');

	}

	private function printAllCategories(){

		$api_categories = $this->getDataFromEndpoint("/taxons");
		// Multidimens. array to simple
		$api_categories = $this->mapMultiDimensionalToSimpleArray($api_categories);

		$categories = array();

		foreach ($api_categories as $row) {
			$Category = new WpptbCategory();
			$Category->setName($row->name);
			$Category->setCode($row->code);
			$Category->setThumb($row->thumb);

			$categories[] = $Category;
		}


		// This is used by function *get_all_categories()
		$GLOBALS['wpptb-all-categories'] = $categories; 
		
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

	private function mapMultiDimensionalToSimpleArray($categories){

		$out = [];

		foreach ($categories as $row) {

			$thumb = '';
			if(count($row->images) > 0){
				$thumb = current($row->images);
				$thumb = WPPTB_BASE_URL . '/media/cache/sylius_small/' . $thumb->path;
			}
			$row->thumb = $thumb;
			$out[] = $row;

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