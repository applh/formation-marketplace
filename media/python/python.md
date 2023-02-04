# ffpmeg

## screen recorder

```
# list devices 
ffmpeg -f avfoundation -list_devices true -i ""


# record screen on MacOS, limit to 10 seconds
ffmpeg -f avfoundation -i "1" -r 30 -t 00:00:10 -pix_fmt yuv420p -c:v libx264 -preset ultrafast -crf 0 -c:a aac -b:a 128k -f mp4 my-out/put.mp4

# NOT WORKING
# record screen on MacOS in webm format, limit to 10s per file
ffmpeg -f avfoundation -i "2" -r 30 -t 00:00:10 -c:v libvpx-vp9 -crf 30 -b:v 0 -c:a libopus -b:a 128k -f webm my-out/put.webm


# NOT WORKING
# record screen on MacOS in webm format, and separate in multiple files and limit to 10s per file
ffmpeg -f avfoundation -i "2" -pix_fmt uyvy422 -c:v libvpx-vp9 -crf 30 -vf fps=30 -f webm -f segment -segment_time 10 -reset_timestamps 1 -segment_format_options movflags=+faststart -segment_list my-out/catfile.ffcat my-out/put-%03d.webm

# NOT WORKING
ffmpeg -f avfoundation -pix_fmt uyvy422 -i "2" -r 30 -c:v libvpx-vp9 -crf 0 -vf fps=30 -f webm -f segment -segment_time 60 -reset_timestamps 1 -segment_list my-out/catfile.ffcat my-out/put-%03d.webm


# WORKING
ffmpeg -f avfoundation -pix_fmt uyvy422 -i "2" -f webm my-out/rec-$(date +%y%m%d-%H%M%S).webm

# NOT WORKING
ffmpeg -f avfoundation -pix_fmt uyvy422 -i "2" -f webm -f segment -segment_time 10 -reset_timestamps 1 -segment_list my-out/catfile.ffcat my-out/rec-$(date +%y%m%d-%H%M%S)-%03d.webm

# NOT WORKING
ffmpeg -f avfoundation -pix_fmt uyvy422 -i "2" -f segment -segment_time 10 my-out/rec-$(date +%y%m%d-%H%M%S)-%03d.webm

# record screen on MacOS in webm format, and separate in multiple files and limit to 10s per file

ffmpeg -f avfoundation -i "2" -pix_fmt uyvy422 -c:v libvpx-vp9 -crf 0 -vf fps=30 -f webm -f segment -segment_time 10 -reset_timestamps 1 -segment_list my-out/catfile.ffcat my-out/put-$(date +%y%m%d-%H%M%S)-%03d.webm

# NOT WORKING
ffmpeg -f avfoundation -framerate 30 -i "2" -pix_fmt uyvy422 -c:v libvpx-vp9 -crf 0 -vf fps=30 -f webm -f segment -segment_time 10 -reset_timestamps 1 -segment_list my-out/catfile.ffcat my-out/put-$(date +%y%m%d-%H%M%S)-%03d.webm


## RECORD SCREEN ON MACOS

```

ffmpeg -f avfoundation -pix_fmt uyvy422 -i "2" -f webm my-out/rec-$(date +%y%m%d-%H%M%S).webm

# record 1 min 
ffmpeg -f avfoundation -pix_fmt uyvy422 -i "2" -f webm -t 00:01:00 my-out/rec-$(date +%y%m%d-%H%M%S).webm

# loop 100 times
for i in {1..100}; do ffmpeg -f avfoundation -pix_fmt uyvy422 -i "2" -f webm -t 00:01:00 my-out/rec-$(date +%y%m%d-%H%M%S).webm; done

```