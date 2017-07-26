<?php

namespace Commands\Preset;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Services\Root;

class Load extends Command
{
  protected function configure()
  {
    $this
      ->setName('preset:load')
      ->addArgument('name', InputArgument::REQUIRED, 'The name of the preset.')
      ->setDescription('open the windows of this preset')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $name = $input->getArgument('name');
    
    $config = new \Services\Config();
    $preset = $config->preset($name);
    
    $wm = new \Services\WindowManager();
    
    $wm->fetchSize();
    
    
    foreach($preset['workspaces'] as $preset)
    {
      $wm->goto($preset['x'], $preset['y']);
      $path = $preset['path'];
      
      $cmd = "xterm -e 'cd $path;atom .;bash'";
      
      exec("screen -dm sh -c \"$cmd\"", $lines, $ret);
      
      sleep(2);
      
      if($ret != 0) {
        throw new \Exception("please install 'screen' command");
      }
      
      $WID = $wm->findWindow($path);
      
      if($WID == null) {
        throw new \Exception("Couldn't find window ID for project '$path'");
      }
      
      $wm->moveTo($preset['x'], $preset['y'], $WID);
    }
  }
}