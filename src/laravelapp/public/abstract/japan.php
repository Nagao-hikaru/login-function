<?php

require('abstract.php');

class Japan extends LanguageAbstract{
  public function greeting() {
    echo 'こんにちは!';
  }
}

$instance = new Japan();

$instance->loveAndPeace();

echo '<br>';

$instance->greeting();