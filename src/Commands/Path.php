<?php

namespace Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Services\Root;

class Path extends Command
{
  protected function configure()
  {
    $this
      ->setName('path')
      ->setDescription('get the path of the solution')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $root = Root::get();
    
    echo "$root\n";
  }
}
