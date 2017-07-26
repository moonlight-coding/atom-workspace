<?php

namespace Services;

class WindowManager
{
  protected $width;
  protected $height;
  protected $screenWidth;
  protected $screenHeight;
  
  public function __construct()
  {
    $this->width = null;
    $this->height = null;
    $this->screenWidth = null;
    $this->screenHeight = null;
  }
  
  public function goto($x, $y)
  {
    $X = $x * $this->screenWidth;
    $Y = $y * $this->screenHeight;
    
    exec("wmctrl -o $X,$Y");
  }
  
  public function moveTo($x, $y, $WID)
  {
    $X = $x * $this->screenWidth;
    $Y = $y * $this->screenHeight;
    
    sleep(2);
    
    exec("wmctrl -i -r $WID -e 0,$X,$Y,600,600");
  }
  
  public function fetchSize()
  {
    exec("wmctrl -d", $lines, $ret);
    
    if($ret != 0) {
      throw new \Exception("'wmctrl -d' command returned value $ret\n");
    }
    
    $line = $lines[0];
    
    $pattern = "[^ ]* +[^ ]* +[^ ]* +(\d+)x(\d+) +[^ ]* +\d+,\d+ +[^ ]* (\d+),(\d+) *(\d+)x(\d+)";
    preg_match("/" . $pattern . "/", $line, $matches);
    
    $this->width = $matches[1];
    $this->height = $matches[2];
    $this->screenWidth = $matches[3] + $matches[5];
    $this->screenHeight = $matches[4] + $matches[6];
    
    //var_dump($matches);
    
    // "0  * DG: 11520x4320  VP: 0,0  WA: 65,24 1855x1056  N/A"
  }
  
  public function findWindow($path)
  {
    exec("wmctrl -l -p", $lines, $ret);
    
    if($ret != 0) {
      throw new \Exception("'wmctrl -l p' returned status $ret");
    }
    
    foreach($lines as $line)
    {
      $pattern = "^0x(\d+).* — (.*) — Atom";
      preg_match("/" . $pattern . "/", $line, $matches);
      
      if(count($matches)) {
        
        $PID = '0x' . $matches[1];
        $match_path = $matches[2];
        
        if($match_path[0] == '~') {
          $match_path = getenv("HOME") . substr($match_path, 1);
        }

        if($path == $match_path) {
          return $PID;
        }
      }
      
    }
    
    return null;
  }
  
  public function getWidth()
  {
    return $this->width;
  }
  
  public function getHeight()
  {
    return $this->height;
  }
  
  public function getScreenWidth()
  {
    return $this->screenWidth;
  }
  
  public function getScreenHeight()
  {
    return $this->screenHeight;
  }
}