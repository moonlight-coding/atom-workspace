<?php

namespace Commands\Preset;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Services\Root;

class Remove extends Command
{
  protected function configure()
  {
    $this
      ->setName('preset:remove')
      ->setDescription('remove a preset')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $root_service = new RootService();
    $root = Root::get();
    
    echo "$root\n";
  }
}
