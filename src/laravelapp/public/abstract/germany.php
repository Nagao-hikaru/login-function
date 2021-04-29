<?php

require('abstract.php');

class Germany extends LanguageAbstract{
  public function greeting() {
    echo '　Guten Tag!';
  }
}

$instance = new Germany();

$instance->loveAndPeace();

echo '<br>';

$instance->greeting();

てんぷれー