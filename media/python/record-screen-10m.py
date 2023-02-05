from mss import mss
import datetime
import cv2
import numpy as np


sct = mss()
# print each monitor
for i, m in enumerate(sct.monitors):
    print(i, m)


# define monitor to record to 2 if not defined
monitor_number = 2
mon = sct.monitors[monitor_number]
width = mon['width']
height = mon['height']


# define bounding box to record
bounding_box = {'top': mon['top'], 'left': mon['left'], 'width': mon['width'], 'height': mon['height'], 'mon': 0}


# define fps
fps = 30

def frame_add (out, f):
    hack1 = cv2.cvtColor(f, cv2.COLOR_RGB2BGR)
    hack1 = cv2.cvtColor(hack1, cv2.COLOR_BGR2RGB)
    out.write(hack1)

def record_screen (duration, fps, width, height, bounding_box):

    nb_frames = duration * fps

    # mp4 or mkv => sizes are similar 1 Mo/s and about 10 fps
    encoder = 'AVC1'
    extension = 'mp4'

    # encoder = 'X264'
    # extension = 'mkv'

    # define codec
    fourcc = cv2.VideoWriter_fourcc(*encoder)

    # define output file
    now = datetime.datetime.now()
    output_file = 'my-out/output-' + now.strftime("%Y%m%d-%H%M%S") + '.' + extension

    # define video writer
    out = cv2.VideoWriter(output_file, fourcc, fps, (width, height))

    # print output file
    print(output_file)

    # record screen
    frame_cur = 0
    while frame_cur < nb_frames:
        img = sct.grab(bounding_box)
        frame = np.array(img)
        frame_add(out, frame)

        frame_cur += 1

        # elapsed time
        # elapsed = frame_cur / fps
        elapsed = datetime.datetime.now() - now
        elapsed = elapsed.total_seconds()

        # stop if duration is reached
        if elapsed > duration:
            print('elapsed time =' , elapsed, 'seconds', frame_cur)
            break

        cv2.imshow('frame', frame)
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break
        
    # release video writer
    out.release()

# record 60 seconds
record_screen(60, fps, width, height, bounding_box)

# close all windows
cv2.destroyAllWindows()
