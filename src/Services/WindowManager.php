<?php

namespace Services;

class WindowManager
{
  protected $width;
  protected $height;
  protected $screenWidth;
  protected $screenHeight;
  protected $vpX;
  protected $vpY;
  protected $offsetX;
  protected $offsetY;
  
  public function __construct()
  {
    $this->width = null;
    $this->height = null;
    $this->screenWidth = null;
    $this->screenHeight = null;
    $this->vpX = null;
    $this->vpY = null;
    $this->offsetX = null;
    $this->offsetY = null;
  }
  
  public function goto($x, $y)
  {
    $X = $x * $this->screenWidth;
    $Y = $y * $this->screenHeight;
    
    exec("wmctrl -o $X,$Y");
  }
  
  public function moveTo($x, $y, $WID)
  {
    echo "vpX: {$this->vpX}, vpY: {$this->vpY}\n";
    $this->goto($this->vpX, $this->vpY);
    
    $X = $x * $this->screenWidth - $this->vpX + $this->offsetX;
    $Y = $y * $this->screenHeight - $this->vpY + $this->offsetY;

    $cmd = "wmctrl -i -r $WID -e 0,$X,$Y,-1,-1";
    
    exec($cmd);
    
    echo $cmd, "\n";  
    
    $this->dump();
  }
  
  public function dump()
  {
    echo "width: ", $this->width, "\n";
    echo "height: ", $this->height, "\n";
    echo "screenWidth: ", $this->screenWidth, "\n";
    echo "screenHeight: ", $this->screenHeight, "\n";
    echo "vpX: ", $this->vpX, "\n";
    echo "vpY: ", $this->vpY, "\n";
    echo "offsetX: ", $this->offsetX, "\n";
    echo "offsetY: ", $this->offsetY, "\n";
  }
  
  public function fetchSize()
  {
    exec("wmctrl -d", $lines, $ret);
    
    if($ret != 0) {
      throw new \Exception("'wmctrl -d' command returned value $ret\n");
    }
    
    $line = $lines[0];
    
    $pattern = "[^ ]* +[^ ]* +[^ ]* +(\d+)x(\d+) +[^ ]* +(\d+),(\d+) +[^ ]* (\d+),(\d+) *(\d+)x(\d+)";
    preg_match("/" . $pattern . "/", $line, $matches);
    
    $this->width = $matches[1];
    $this->height = $matches[2];
    $this->vpX = $matches[3];
    $this->vpY = $matches[4];
    $this->offsetX = $matches[5];
    $this->offsetY = $matches[6];
    $this->screenWidth = $matches[5] + $matches[7];
    $this->screenHeight = $matches[6] + $matches[8];
    
    
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
      $pattern = "^0x([\da-f]+).* — (.*) — Atom";
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
  
  public function getViewportX()
  {
    return $this->vpX;
  }
  
  public function getViewportY()
  {
    return $this->vpY;
  }
}