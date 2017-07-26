<?php

namespace Commands\Preset;

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
      ->setName('preset:create')
      ->addArgument('name', InputArgument::REQUIRED, 'The name of the preset.')
      ->setDescription('create a preset')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $name = $input->getArgument('name');
    
    $config = new \Services\Config();
    $config->createPreset($name);
    $config->save();
  }
}
