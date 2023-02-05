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

# define output file
now = datetime.datetime.now()
output_file = 'my-out/output-' + now.strftime("%Y%m%d-%H%M%S") + '.mkv'

# print output file
print(output_file)

# define fps
fps = 30

# define codec
fourcc = cv2.VideoWriter_fourcc(*'X264')

# define video writer
out = cv2.VideoWriter(output_file, fourcc, fps, (width, height))


def frame_add (out, f):
    hack1 = cv2.cvtColor(f, cv2.COLOR_RGB2BGR)
    hack1 = cv2.cvtColor(hack1, cv2.COLOR_BGR2RGB)
    out.write(hack1)

# record screen
while True:
    img = sct.grab(bounding_box)
    frame = np.array(img)
    frame_add(out, frame)

    cv2.imshow('frame', frame)
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# release video writer
out.release()

# close all windows
cv2.destroyAllWindows()
