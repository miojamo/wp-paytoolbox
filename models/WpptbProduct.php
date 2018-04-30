<?php

class WpptbProduct{
	
	private $name;
	private $code;
	private $price;
	private $currency;
	private $thumb;
    private $shortDescription;
	private $description;
	private $images = array();
	private $quicksellUrl;
    private $categories;


    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;

        return $this;
    }

    public function getCode(){
        return $this->code;
    }

    public function setCode($code){
        $this->code = $code;

        return $this;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setPrice($price){
        $this->price = $price;

        return $this;
    }

    public function getCurrency(){
        return $this->currency;
    }

    public function setCurrency($currency){
        $this->currency = $currency;

        return $this;
    }

    public function getThumb(){
        return $this->thumb;
    }

    public function setThumb($thumb){
        $this->thumb = $thumb;

        return $this;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;

        return $this;
    }

    public function getShortDescription(){
        return $this->shortDescription;
    }
    public function setShortDescription($shortDescription){
        $this->shortDescription = $shortDescription;
        return $this;
    }

    public function getImages(){
        return $this->images;
    }

    public function setImages($images){
        $this->images = $images;

        return $this;
    }

    public function getQuicksellUrl(){
        return $this->quicksellUrl;
    }

    public function setQuicksellUrl($quicksellUrl){
        $this->quicksellUrl = $quicksellUrl;

        return $this;
    }

    public function getCategories(){
        return $this->categories;
    }

    public function setCategories($categories){
        $this->categories = $categories;

        return $this;
    }

    public function printCategories($separator){
        foreach ($this->getCategories() as $tmp_category) {
            echo $tmp_category->getName();
            echo $separator;
        }
    }

}