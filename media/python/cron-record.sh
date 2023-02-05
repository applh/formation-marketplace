#!/bin/sh

say "Big Brother is here"

# set the number of times to loop
xl=1

# set duration of each recording
# 00:10:00 = 10 minutes
#duration=00:10:00
duration=00:01:00

# loop xl times
for i in {1..$xl}
do 
    /opt/homebrew/bin/ffmpeg -nostats -loglevel 0 -n -f avfoundation -pix_fmt uyvy422 -i "2" -crf 50 -f webm -t $duration my-out/rec-$(date +%y%m%d-%H%M%S).webm
done
