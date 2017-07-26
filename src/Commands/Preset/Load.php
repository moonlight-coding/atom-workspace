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
      
      if($wm->findWindow($path) != null) {
        //Window on $path already opened
      } 
      else {
        $cmd = "xterm -e 'cd $path;atom .;bash'";
        
        exec("screen -dm sh -c \"$cmd\"", $lines, $ret);
      
        if($ret != 0) {
          throw new \Exception("please install 'screen' command");
        }
      
        sleep(2);
      }
      
      $wm->goto($wm->getViewportX() / $wm->getScreenWidth(), $wm->getViewportY() / $wm->getScreenHeight());
      
      $timer = 0;
      
      do {
        sleep(0.2);
        $WID = $wm->findWindow($path);
      
      /*if($WID == null) {
        throw new \Exception("Couldn't find window ID for project '$path'");
      }*/
      
        if($WID == null) {
          //echo "WID is null !\n";
        }
        
        $timer ++;
      
      } while($WID == null && $timer < (5 * 60)); // 60 secs timeout 
      
      $wm->moveTo($preset['x'], $preset['y'], $WID);
      // 2nd move, to counter Unity (Ubuntu) bug
      sleep(0.2);
      $wm->moveTo($preset['x'], $preset['y'], $WID);
      
      exec("xdotool windowfocus $WID && xdotool key ctrl+super+Up");
      //exec("xdotool windowfocus $WID && xdotool key ctrl+ALT_L+KP_5");
    }
  }
}
