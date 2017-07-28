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

You can define profiles, which are named 'presets'.

Each preset contains the projects to open, in which workspace. 

### Create a preset

- `atom-workspace preset:create $PRESET_NAME`


### Add a project in a preset

- `atom-workspace preset:workspace:create $PRESET_NAME $X $Y $PROJECT_PATH`  with `$X` and `$Y` the positions of the workspaces [0,0], [0,1], [2,2] etc.. , and `$PROJECT_PATH` the absolute path of your project to launch.
- `atom-workspace preset:workspace:create $PRESET_NAME $X $Y` same as previous command, but with current folder
- `atom-workspace preset:workspace:create $PRESET_NAME` same as previous command, but with current workspace position.

### Open the projects 

- `atom-workspace preset:load $PRESET_NAME` will open `xterm` in any of your registered workspaces and launch an atom window. 
- `atom-workspace load $PRESET_NAME` is an alias


## LICENSE

MIT License.
