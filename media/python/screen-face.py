import cv2
import datetime
from mss import mss
import numpy as np
import os

# https://python-mss.readthedocs.io/examples.html

# if cv2 is not installed, run the following command in the terminal
# pip install opencv-python

# https://docs.opencv.org/4.7.0/dd/d43/tutorial_py_video_display.html

# https://trac.ffmpeg.org/wiki/Capture/Desktop
# ffmpeg -f avfoundation -list_devices true -i ""
# ffmpeg -f avfoundation -i "<screen device index>:<audio device index>" output.mkv
# ffmpeg -f avfoundation -i "2:none" output.mkv
# ffmpeg -f avfoundation -i "2:" -crf 0 output.webm
# https://trac.ffmpeg.org/wiki/HWAccelIntro
# https://stackoverflow.com/questions/20095667/ffmpeg-record-the-screen-but-only-remember-the-last-5-minutes
# ffmpeg -f avfoundation -i "2:" -f segment -segment_time 60 -segment_format_options movflags=+faststart -segment_list catfile.ffcat -reset_timestamps 1 output-%3d.mp4
# http://wiki.webmproject.org/adaptive-streaming/instructions-to-do-webm-live-streaming-via-dash
# ffmpeg -f avfoundation -i 2: -pix_fmt uyvy422 -c:v libvpx-vp9 -f webm_chunk -header stream.hdr -chunk_start_index 1 stream_%d.chk

# https://sonnati.wordpress.com/2011/08/30/ffmpeg-%e2%80%93-the-swiss-army-knife-of-internet-streaming-%e2%80%93-part-iv/
# ffmpeg -f avfoundation -pix_fmt uyvy422 -i 2: -an -c:v libvpx-vp9 -crf 0 -threads 0 -f tee "my-out/all.webm|my-out/part.webm" 


# ffmpeg -f avfoundation -i "2:" -an -crf 0 -f mpegts - | ffmpeg -f mpegts -i - -f segment -segment_time 10 my-out/seg_%3d.mp4

face_cascade = cv2.CascadeClassifier('haarcascade_frontalface_default.xml')
eye_cascade = cv2.CascadeClassifier('haarcascade_eye.xml')


sct = mss()
# print each monitor
for i, m in enumerate(sct.monitors):
    print(i, m)

monitor_number = 2
mon = sct.monitors[monitor_number]
width = mon['width']
height = mon['height']

bounding_box = {'top': mon['top'], 'left': mon['left'], 'width': mon['width'], 'height': mon['height'], 'mon': 0}

img = sct.grab(bounding_box)
frame = np.array(img)

gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
faces = face_cascade.detectMultiScale(gray, 1.3, 5)

for (x,y,w,h) in faces:
    # To draw a rectangle in a face
    cv2.rectangle(frame,(x,y),(x+w,y+h),(255,255,0),2)
    roi_gray = gray[y:y+h, x:x+w]
    roi_color = frame[y:y+h, x:x+w]

    # Detects eyes of different sizes in the input image
    eyes = eye_cascade.detectMultiScale(roi_gray)

    # To draw a rectangle in eyes
    for (ex,ey,ew,eh) in eyes:
        cv2.rectangle(roi_color,(ex,ey),(ex+ew,ey+eh),(0,127,255),2)

"""
# alternative method
t_msec = 1000*(minutes*60 + seconds)

video.set(cv2.CAP_PROP_POS_MSEC, t_msec)
ret, frame = video.read()
"""


# Display and save frame
# cv2.imshow('frame', frame); cv2.waitKey(0)

cv2.imwrite('my-out/screenshot.png',frame)

# write frame to video output.mkv 'X264' 
# (or 'vp09' for webm but very slow)
# fourcc = cv2.VideoWriter_fourcc(*'X264')
# height = video.get(cv2.CAP_PROP_FRAME_HEIGHT)
# width = video.get(cv2.CAP_PROP_FRAME_WIDTH)
#height = frame.shape[0]
#width = frame.shape[1]

# out = cv2.VideoWriter('output.mp4', fourcc, fps, (frame.shape[1], frame.shape[0]))

# output file with date output-YYMMDD-HHMMSS.mkv
now = datetime.datetime.now()
date_tag = now.strftime("%y%m%d-%H%M%S")
output_file = 'my-out/output-' + date_tag + '.mkv'
out1_file = 'my-out/out1-' + date_tag + '.mkv'
outcrop_file = 'my-out/crop-' + date_tag + '.mkv'

output_codec = 'X264'
# output_file = 'output-' + date_tag + '.avi'
# output_codec = 'MJPG'

scale = 0.25
out_w = int(scale * width)
out_h = int(scale * height)

sq_count = 10
sq_h0 = int(out_h / sq_count)
sq_w0 = int(out_w / sq_count)

fps = 30
print('frames per second =',fps)
fourcc = cv2.VideoWriter_fourcc(*output_codec)
fourcc1 = cv2.VideoWriter_fourcc(*output_codec)
fourcc2 = cv2.VideoWriter_fourcc(*output_codec)

out = cv2.VideoWriter(output_file, fourcc, fps, (out_w, out_h))
out1 = cv2.VideoWriter(out1_file, fourcc1, fps, (out_w, out_h))
out2 = cv2.VideoWriter(outcrop_file, fourcc2, fps, (4*sq_w0, 10*sq_h0))

cv2.imshow('frame', frame)

# play the video frame by frame in window
frame_current = 0
xt = None
yt = None

while True:

    ret = True
    img = sct.grab(bounding_box)
    frame = np.array(img)
    frame_current += 1
    

    if ret == True:
        out_img = cv2.resize(frame, None, fx=scale, fy=scale, interpolation=cv2.INTER_LINEAR)

        frame_hack1 = cv2.cvtColor(out_img, cv2.COLOR_RGB2BGR)
        frame_hack1 = cv2.cvtColor(frame_hack1, cv2.COLOR_BGR2RGB)
        out1.write(frame_hack1)
        # scale2 = 0.5 * scale
        # gray0 = cv2.resize(out_img, None, fx=scale2, fy=scale2, interpolation=cv2.INTER_LINEAR)

        gray = cv2.cvtColor(out_img, cv2.COLOR_BGR2GRAY)
        faces = face_cascade.detectMultiScale(gray, 1.3, 5)
        # faces = face_cascade.detectMultiScale(gray, 2, 2)

        # frame_hack = cv2.imread(frame_name)
        # hsv = cv2.cvtColor(out_img, cv2.COLOR_BGR2HSV)
        #set the lower and upper bounds for the green hue
        # cur_color = 160 # frame_current % 270;
        # lower_color = np.array([cur_color, 100, 50])
        # upper_color = np.array([cur_color+20, 255, 255])
        # mask = cv2.inRange(hsv, lower_color, upper_color)
        # out_img = cv2.bitwise_or(hsv, hsv, mask=mask)
        # out_img = hsv

        # count faces
        nbf = len(faces)

        if (nbf > 0):
            crop = None
            for (x,y,w,h) in faces:

                if (xt is None):
                    xt = x
                    yt = y
                else:
                    # move to x and y by 1/10 of the distance
                    xt = int(xt + 0.05*(x-xt))
                    yt = int(yt + 0.05*(y-yt))

                # To draw a rectangle in a face
                x2 = x + w
                y2 = y + h

                # copy region
                if (crop is None):
                    # max square
                    sq_max = max(w,h)

                    xa = int(xt / sq_w0) * sq_w0
                    ya = int(yt / sq_h0) * sq_h0
                    xb = int(min(xa + 2*sq_w0, out_w))
                    yb = int(min(ya + 0.5*sq_count*sq_h0, out_h))
                    zoom = 2
                    crop = cv2.resize(out_img[(ya):(yb), (xa):(xb)], None, fx=zoom, fy=zoom, interpolation=cv2.INTER_AREA)

                    frame_hack2 = cv2.cvtColor(crop, cv2.COLOR_RGB2BGR)
                    frame_hack2 = cv2.cvtColor(frame_hack2, cv2.COLOR_BGR2RGB)
                    out2.write(frame_hack2)

                    # draw rectangles 10x10
                    for i in range(sq_count):
                        for j in range(sq_count):
                            cv2.rectangle(out_img,(0+j*sq_w0,0+i*sq_h0),(0+(j+1)*sq_w0,0+(i+1)*sq_h0),(0,0,255),1)


                    cv2.rectangle(out_img,(xa,ya),(xb,yb),(0,0,255),2)
                    out_img[(out_h-zoom*(yb-ya)):(out_h), (out_w-zoom*(xb-xa)):out_w] = crop

                cv2.rectangle(out_img,(x,y),(x2,y2),(255,255,0),2)

                if xt is not None:    
                    cv2.rectangle(out_img, (xt, yt), (xt+sq_w0, yt+sq_h0),(255,0,255),1)

                roi_gray = gray[y:y+4*h, x:x+w]
                roi_color = out_img[y:y+h, x:x+w]

                # Detects eyes of different sizes in the input image
                eyes = eye_cascade.detectMultiScale(roi_gray)

            # To draw a rectangle in eyes
            for (ex,ey,ew,eh) in eyes:
                cv2.rectangle(roi_color,(ex,ey),(ex+ew,ey+eh),(0,127,255),2)

            now = datetime.datetime.now()
            frame_now = now.strftime("%M:%S")

            # add text frame number as integer and number of faces to frame
            line = '' + str(frame_current) + ' (' + str(nbf) + ') ' + frame_now
            cv2.putText(out_img, line, (10, 50), cv2.FONT_HERSHEY_SIMPLEX, 1, (255, 255, 255), 2, cv2.LINE_AA)

            # save frame to video
            # https://cloudinary.com/guides/bulk-image-resize/python-image-resize-with-pillow-and-opencv
            # out_img = cv2.resize(frame, None, fx=0.5, fy=0.5, interpolation=cv2.INTER_AREA)

            # write the frame in png format with frame number
            frame_name = 'frames/output-frame-' + date_tag + '-' + str(frame_current) + '.png'
            # cv2.imwrite(frame_name, out_img)
            

            frame_hack = cv2.cvtColor(out_img, cv2.COLOR_RGB2BGR)
            frame_hack = cv2.cvtColor(frame_hack, cv2.COLOR_BGR2RGB)

            # https://docs.opencv.org/4.x/d5/d69/tutorial_py_non_local_means.html
            # frame_hack = cv2.fastNlMeansDenoisingColored(out_img, None, 10, 10, 7, 21)

            # add frame to video
            out.write(frame_hack)
            # out2.write(crop)

            # show frame
            cv2.imshow('frame', frame_hack)
            cv2.imshow('crop', crop)

            # delete frame file
            # os.remove(frame_name)

            if cv2.waitKey(1) & 0xFF == ord('q'):
                break
    else:
        break

# cleanup
out.release()
out1.release()
out2.release()

cv2.destroyAllWindows()