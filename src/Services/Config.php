<?php

namespace Services;

class Config
{
  protected $conf;
  
  protected function getFilename()
  {
    return Root::get() . "/context/config.json";
  }
  
  public function __construct()
  {
    $filename = $this->getFilename();
    
    if(file_exists($filename)) {
      $this->conf = json_decode(file_get_contents($filename), true);
    }
    else {
      $this->conf = [
        "presets" => []
      ];
    }
  }
  
  public function createPreset($name)
  {
    if(array_key_exists($name, $this->conf['presets'])) {
      throw new \Exception("Preset already created");
    }
    $this->conf['presets'][$name] = [
      'workspaces' => []
    ];
  }
  
  public function presets()
  {
    return $this->conf['presets'];
  }
  
  public function preset($name)
  {
    if(!array_key_exists($name, $this->conf['presets'])) {
      throw new \Exception("Preset doesn't exist");
    }
    
    return $this->conf['presets'][$name];
  }
  
  public function createPresetWorkspace($name, $x, $y, $path)
  {
    if(!array_key_exists($name, $this->conf['presets'])) {
      throw new \Exception("Preset '$name' doesn't exist");
    }
    
    $this->conf['presets'][$name]['workspaces'][] = [
      "x" => $x,
      "y" => $y,
      "path" => $path
    ];
  }
  
  public function save()
  {
    file_put_contents($this->getFilename(), json_encode($this->conf, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
  }
  
  
}
