<?php

namespace Services;

class Root
{
  public static function get()
  {
    $root = __DIR__;
    $phar = false;
    
    if($root[0] != "/") {
      $phar = true;
      $root = substr($root, 7);
    }
    
    $exploded = explode("/", $root);
    $n = count($exploded);
    unset($exploded[$n - 1]);
    unset($exploded[$n - 2]);

    if($phar)
      unset($exploded[$n - 3]);

    return implode("/", $exploded);
  }
}


