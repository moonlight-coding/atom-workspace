# atom-workspace

## Purpose

The use of workspaces is really usefull, I often have dozens of workspace's screens with 1 atom + 1 shell inside them.

It always takes several minutes to open the right projects in the right workspaces, this program allows to define your workspace configurations, and open all your projects in 
a simple command.

## Requirements

- screen
- wmctrl

Tested on Ubuntu 16.04 with Unity.

## Installation

```
composer install
./build.sh
sudo ./install.sh
```

## How to use

- `atom-workspace preset:create "mypreset"`
- `atom-workspace preset:workspace:create "mypreset" $X $Y $PROJECT_PATH`  with `$X` and `$Y` the positions of the workspaces [0,0], [0,1], [2,2] etc.. , and `$PROJECT_PATH` the absolute path of your project to launch.
- `atom-workspace preset:load "mypreset"` will open `xterm` in any of your registered workspaces and launch an atom window. 


## LICENSE

MIT License.
