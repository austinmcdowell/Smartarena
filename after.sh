#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.

set -e

# installs dependencies
install_dependencies() {
  cd ~/$1

  # ffmpeg
  if [ ! -e /usr/local/ffmpeg/ffmpeg ]; then
    wget https://johnvansickle.com/ffmpeg/builds/ffmpeg-git-64bit-static.tar.xz -O ffmpeg.tar.xz
    tar -Jxf ffmpeg*.tar.xz
    rm ffmpeg*.tar.xz
    sudo mv ffmpeg-* /usr/local/ffmpeg
    sudo ln -s /usr/local/ffmpeg/ffmpeg /usr/local/bin/
    sudo ln -s /usr/local/ffmpeg/ffprobe /usr/local/bin/
    sudo ln -s /usr/local/ffmpeg/qt-faststart /usr/local/bin/
    sudo ln -s /usr/local/ffmpeg/qt-faststart /usr/local/bin/qtfaststart
  fi

}

install_dependencies