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

    	wp_enqueue_style( 'wpptb-uikit', plugins_url('node_modules/uikit/dist/css/uikit.css', __FILE__) );

		wp_enqueue_script( 'wpptb-uikitjs',  plugins_url('node_modules/uikit/dist/js/uikit.js', __FILE__) );
		wp_enqueue_script( 'wpptb-uikiticons',  plugins_url('node_modules/uikit/dist/js/uikit-icons.min.js', __FILE__) );

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
// echo "<pre>";
// var_dump($api_product);
// echo "</pre>";

		$Product = $this->mapApiResponseToProductModel($api_product);

		$GLOBALS['wpptb-product'] = $Product;
		$this->showPage('product');
	}


	private function printCategoryProducts($category){

		$prods = $this->getDataFromEndpoint("/taxon-products/".$category . '?channel=' . $this->channel);

		$products = array();

		foreach ($prods['items'] as $row) {

			$Product = $this->mapApiResponseToProductModel($row);

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

			if($row->code=='category'){ continue; }

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
	* @param object/array $api_product Response from an API in array format
	* 
	* @return object WpptbProduct
	**/
	private function mapApiResponseToProductModel($api_product){

		$api_product = (array) $api_product;

		$Product = new WpptbProduct();// output variable

		$price = "-";
		$currency = "";
		$thumb = "";

		// Don't use isset() so we see if an error occured!


		$price = $api_product['variants']->{$api_product['code']}->price->current;

		$price = $price / 100;

		$currency = $api_product['variants']->{$api_product['code']}->price->currency;
		

		if( ! empty($api_product['images'])){
			$img1 = current($api_product['images']);
			$thumb = WPPTB_BASE_URL . '/media/cache/product_medium/' . $img1->path;
		}

		$Product->setCode($api_product['code']);
		$Product->setName($api_product['name']);
		$Product->setCurrency($currency);
		$Product->setPrice($price);
		$Product->setThumb($thumb);
		$Product->setDescription($api_product['description']);
		$Product->setShortDescription($api_product['shortDescription']);
		$Product->setImages($api_product['images']);
		$Product->setQuicksellUrl($api_product['quicksell']->checkout);

		// Set categories
		$product_categories = array();

		$api_categories = $api_product['taxons']->others;
		foreach ($api_categories as $value) {
			$Category = new WpptbCategory();
			$Category->setName($value);
			$product_categories[] = $Category;
		}

		$Product->setCategories($product_categories);

		return $Product;

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

		$json_resp = array();
		try{
			$response = $this->client->request($method, $this->apiUrl . $endpoint, [
			//	'body' =>  implode("&", $params)
	//			'json' => []
				'form_params' => $params,
			]);
		} catch(Exception $e){
			error_log( $e->getTraceAsString() );
			echo '<meta http-equiv="refresh" content="0;url=/?p=404" />';
			return $json_resp;
		}

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