<?php
// 抽象クラスでは共通の機能を実装して、子クラスにそれぞれ行って欲しい機能を強制します！！
abstract class LanguageAbstract {
  public function loveAndPeace(){
    echo '世界の共通言語はlove and peaceだ';
  }

  abstract public function greeting();
    // 強制させるメソッドは中身を書くことはできません
}