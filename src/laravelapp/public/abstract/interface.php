<?php

interface ProductAbstract {

  // インターフェースは抽象クラスとは違ってメソッドの強制しか書けないので、変数、関数をセットする事ができない

  public function getProduct();
    // 強制させるメソッドは中身をかけない
}
class BaseProduct {
  public function echoProduct(){
    echo '親クラスです';
  }
}

// インターフェースの場合は複数景勝する事ができる、逆に言えば抽象クラスは単一継承になる。
class Product {


  private $product = [];

  function __construct() {
    $this->product = $product;
  }

  public function getProduct() {
    echo Carbon::now();
  }

  public function echoProduct(){
    echo '上書き済みです';
  }
}

$instance = new Product('test');

$instance->getProduct();