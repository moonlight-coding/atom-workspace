<?php

require __DIR__ . "/../vendor/autoload.php";

use Symfony\Component\Console\Application;

$application = new Application();
//$application->setCatchExceptions(false);

// register commands
$commands = [
  "Path",
  "Preset/Create",
  "Preset/Workspace/Create",
  "Preset/Load",
  "Preset/List_",
  "Preset/Remove"
];

foreach($commands as $c) {
  $Command = str_replace("/", "\\", $c);
  $n = "Commands\\{$Command}";
  $application->add(new $n());
}

// run app
$application->run();

