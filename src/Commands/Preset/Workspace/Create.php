<?php

namespace Commands\Preset\Workspace;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Services\Root;

class Create extends Command
{
  protected function configure()
  {
    $this
      ->setName('preset:workspace:create')
      ->addArgument('name', InputArgument::REQUIRED, 'The name of the preset.')
      ->addArgument('x', InputArgument::OPTIONAL, 'horizontal | default is current workspace X component')
      ->addArgument('y', InputArgument::OPTIONAL, 'vertical | default is current workspace Y component')
      ->addArgument('path', InputArgument::OPTIONAL, 'The path of the project to open | default is current directory')
      ->setDescription('create a preset')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $name = $input->getArgument('name');
    $x = $input->getArgument('x');
    $y = $input->getArgument('y');
    $path = $input->getArgument('path');
    
    $wm = new \Services\WindowManager();
    $wm->fetchSize();
    
    if($x == null) {
      $x = $wm->getWorkspaceX();
    }
    if($y == null) {
      $y = $wm->getWorkspaceY();
    }
    if($path == null) {
      $path = getcwd();
    }
    
    $config = new \Services\Config();
    $config->createPresetWorkspace($name, $x, $y, $path);
    $config->save();
  }
}
