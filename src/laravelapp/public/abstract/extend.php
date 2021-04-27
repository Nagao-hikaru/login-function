<?php

class BaseProduct {
  public function echoProduct(){
    echo '親クラスです';
  }
}

class Product extends BaseProduct {

  private $product = [];

  function __construct() {
    $this->product = $product;
  }

  public function getProduct() {
    echo $this->product;
  }

  public function addProduct($item) {
    $this->product .= $item;
  }

  public static function getStaticProduct($str) {
    echo $str;
  }

  public function echoProduct(){
    echo '上書き済みです';
  }
}

$instance = new Product('test');

$instance->echoProduct();