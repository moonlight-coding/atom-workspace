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
      ->addArgument('x', InputArgument::REQUIRED, 'horizontal')
      ->addArgument('y', InputArgument::REQUIRED, 'vertical')
      ->addArgument('path', InputArgument::REQUIRED, 'The path of the project to open.')
      ->setDescription('create a preset')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $name = $input->getArgument('name');
    $x = $input->getArgument('x');
    $y = $input->getArgument('y');
    $path = $input->getArgument('path');
    
    $config = new \Services\Config();
    $config->createPresetWorkspace($name, $x, $y, $path);
    $config->save();
  }
}
