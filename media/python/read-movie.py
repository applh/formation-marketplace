import cv2
import numpy as np
import imutils
import datetime
from PIL import Image, ImageFilter

movie_file = 'my-out/movie7.webm'

# define fps
fps = 3 # 30

mini = 1024 # 512 # 256 # 512
zeros = np.zeros((mini, mini), dtype="uint8")

def read_movie (movie_file):
    out = create_movie()

    # read movie movie.webm with opencv
    cap = cv2.VideoCapture(movie_file)
    while(cap.isOpened()):
        ret, frame = cap.read()    
        if ret==True:
            parse_frame(frame, out)
            if cv2.waitKey(1) & 0xFF == ord('q'):
                break
        else:
            break

    # release video writer
    cap.release()
    cv2.destroyAllWindows()

    if out is not None:
        out.release()

def frame_add (out, f):
    hack1 = cv2.cvtColor(f, cv2.COLOR_RGB2BGR)
    hack1 = cv2.cvtColor(hack1, cv2.COLOR_BGR2RGB)
    out.write(hack1)

def create_movie ():
    out = None
    # create output file if not exists
    if out is None:
        # mp4 or mkv => sizes are similar 1 Mo/s and about 10 fps
        encoder = 'avc1'
        extension = 'mp4'

        # define codec
        fourcc = cv2.VideoWriter_fourcc(*encoder)

        # define output file
        now = datetime.datetime.now()
        output_file = 'my-out/output-' + now.strftime("%Y%m%d-%H%M%S") + '.' + extension

        # define video writer
        out = cv2.VideoWriter(output_file, fourcc, fps, (mini, mini))

        # print output file
        print(output_file)

    return out
        

def parse_frame (frame, out):
    # get frame size
    height, width, layers = frame.shape
    # crop frame to square center
    min = height if height < width else width

    # crop frame left
    focus = 'left'

    top = int((height-min)/2)
    bottom = int((height-min)/2)+min
    left = 0
    right = min

    # crop frame right
    if focus == 'right':
        top = int((height-min)/2)
        bottom = int((height-min)/2)+min
        left = int(width-min)
        right = width

    if focus == 'center':
        top = int((height-min)/2)
        bottom = int((height-min)/2)+min
        left = int((width-min)/2)
        right = int((width-min)/2)+min

    frame0 = frame[top:bottom, left:right]

    # if focus == 'left':
    #     frame0 = frame[int((height-min)/2):int((height-min)/2)+min, 0:min]

    # crop frame right
    # if focus == 'right':
        # frame0 = frame[int((height-min)/2):int((height-min)/2)+min, int(width-min):width]

    # crop frame center
    # if focus == 'center':
        # frame0 = frame[int((height-min)/2):int((height-min)/2)+min, int((width-min)/2):int((width-min)/2)+min]

    # resize frame to minixmini
    frame2 = cv2.resize(frame0, (mini, mini), interpolation = cv2.INTER_AREA)

    # resize frame to cover minixmini pixels
    # frame = imutils.resize(frame, width=mini)
    # frame = cv2.resize(frame, (int(width/2), int(height/2)))

    # separate frame in 3 channels
    b,g,r = cv2.split(frame2)
    # https://pyimagesearch.com/2021/01/23/splitting-and-merging-channels-with-opencv/

    # extract predominant color for each pixel
    for i in range(0, mini):
        for j in range(0, mini):
            if b[i,j] > g[i,j] and b[i,j] > r[i,j]:
                g[i,j] = 0
                r[i,j] = 0
            elif g[i,j] > b[i,j] and g[i,j] > r[i,j]:
                b[i,j] = 0
                r[i,j] = 0
            elif r[i,j] > b[i,j] and r[i,j] > g[i,j]:
                b[i,j] = 0
                g[i,j] = 0
    
    frame3 = cv2.merge((b,g,r))
    # save frame to movie
    # frame_add(out, frame3)

    # https://pillow.readthedocs.io/en/latest/reference/index.html
    # https://realpython.com/image-processing-with-the-python-pillow-library/
    # frame2 find edge with PIL filter FIND_EDGES
    frame_edge = Image.fromarray(frame2)
    frame_edge = frame_edge.convert('L')
    # frame_edge = frame_edge.filter(ImageFilter.SMOOTH)
    frame_edge = frame_edge.filter(ImageFilter.FIND_EDGES)
    frame_edge = np.array(frame_edge)
    cv2.imshow('frame_edge',frame_edge)
    frame_add(out, frame_edge)

    # print(frame2.shape[:2])
    # show frame
    # cv2.imshow('frame0',frame0)
    cv2.imshow('frame2',frame2)
    cv2.imshow('frame3',frame3)
    cv2.imshow('frame_edge',frame_edge)

    cv2.imshow('blue', cv2.merge([b, zeros, zeros]))
    cv2.imshow('green', cv2.merge([zeros, g, zeros]))
    cv2.imshow('red', cv2.merge([zeros, zeros, r]))

# create windows
cv2.namedWindow('frame2', cv2.WINDOW_NORMAL)
cv2.namedWindow('frame3', cv2.WINDOW_NORMAL)
cv2.namedWindow('frame_edge', cv2.WINDOW_NORMAL)
cv2.namedWindow('blue', cv2.WINDOW_NORMAL)
cv2.namedWindow('green', cv2.WINDOW_NORMAL)
cv2.namedWindow('red', cv2.WINDOW_NORMAL)

cv2.moveWindow('frame2', 0, 0) 
cv2.moveWindow('frame3', 550, 0) 
cv2.moveWindow('frame_edge', 1100, 0) 
cv2.moveWindow('blue', 000, 550) 
cv2.moveWindow('green', 550, 550) 
cv2.moveWindow('red', 1100, 550) 

read_movie(movie_file)

