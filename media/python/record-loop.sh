#!/bin/bash

curdir=`dirname $0`

# say "Big Brother is here"

cd $curdir

# set the number of times to loop
xl=10

# set duration of each recording
# 00:10:00 = 10 minutes
duration=00:10:00

# list devices 
# ffmpeg -f avfoundation -list_devices true -i ""


# loop xl times
for (( i=1; i<=$xl; i++ ))
do
    curtime=$(date +%y%m%d-%H%M%S)
    curfile=$curdir/my-out/rec-$curtime.webm
    echo "Recording $i of $xl ($curfile)"
    /opt/homebrew/bin/ffmpeg -nostats -loglevel 0 -n -f avfoundation -pix_fmt uyvy422 -i "2" -crf 50 -f webm -t $duration $curfile
done

#/opt/homebrew/bin/ffmpeg -nostats -loglevel error -n -f avfoundation -pix_fmt uyvy422 -i "2" -crf 50 -f webm -t $duration $curdir/my-out/rec-$(date +%y%m%d-%H%M%S).webm
# watch -n 600 ./record-loop.sh