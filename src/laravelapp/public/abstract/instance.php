<?php

class Product {

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
}

$instance = new Product('test');