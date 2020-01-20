<?php

class ShortCode {
  private static $chars = "abcdefghijklmnopqrstuvwxyz|0123456789";
  private static $codeLength = 6;

  public function generateRandomString() {
    $sets = explode('|', self::$chars);
    $all = '';
    $randString = '';

    foreach($sets as $set){
        $randString .= $set[array_rand(str_split($set))];
        $all .= $set;
    }
    $all = str_split($all);
    for($i = 0; $i < self::$codeLength - count($sets); $i++){
        $randString .= $all[array_rand($all)];
    }
    $randString = str_shuffle($randString);

    return $randString;
  }
}
