<?php

class WpptbCategory{
	
	private $name;
	private $code;
	private $thumb;
	
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

    public function getThumb(){
        return $this->thumb;
    }

    public function setThumb($thumb){
        $this->thumb = $thumb;

        return $this;
    }

}