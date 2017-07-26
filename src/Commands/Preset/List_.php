<?php

namespace Commands\Preset;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Services\Root;

class List_ extends Command
{
  protected function configure()
  {
    $this
      ->setName('preset:list')
      ->setDescription('list the presets')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $config = new \Services\Config();
    $presets = $config->presets();
    
    foreach($presets as $name => $preset)
    {
      echo "- $name:\n";
      
      foreach($preset['workspaces'] as $workspace) {
        $x = $workspace['x'];
        $y = $workspace['y'];
        $path = $workspace['path'];
        
        echo "  [$x, $y] $path\n";
      }
      
    }
  }
}
