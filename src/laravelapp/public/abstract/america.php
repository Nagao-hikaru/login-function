<?php

require('abstract.php');

class America extends LanguageAbstract{
  public function greeting() {
    echo 'Hello!';
  }
}

$instance = new America();

$instance->loveAndPeace();

echo '<br>';

$instance->greeting();