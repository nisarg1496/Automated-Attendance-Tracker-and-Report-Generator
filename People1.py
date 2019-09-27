
import numpy as np
import cv2
import Person
import time
#import pymysql.cursors
#import pymysql
import MySQLdb


cnt_up   = 0
cnt_down = 0
cnt_inside=cnt_down-cnt_up
db = MySQLdb.Connect(host='localhost', port=3309, user='root', passwd='', db='attendance_tracking')


    # Create a Cursor object
cur = db.cursor()
#cur.execute("create database apple")
#cur.execute("use apple")
#table='create table count_people(people_inside int(100))'
#cur.execute(table)

    # Create a query string. It can contain variables
query_string = ("Update `people_inside` set `people_count`=0 where `people_count` !=0");

    # Execute the query
cur.execute(query_string)
#cur.execute('use attendance_tracking')
#table='create table count_people(people_inside int(100))'
#cur.execute(table)

    # Get all the rows present the database
#for each_row in cur.fetchall():
   #print (each_row[0])

#db.close()

   



cap = cv2.VideoCapture("http://192.168.0.100:4747/video")
#f=open("apple.txt","w+")


for i in range(19):
   cap.get(i)
#cap.set(3,1000)
#cap.set(4,750)
w = cap.get(3)
h = cap.get(4)
frameArea = h*w
areaTH = frameArea/50

line_up = int(2*(h/5))
line_down   = int(3*(h/5))

up_limit =   int(1*(h/5))
down_limit = int(4*(h/5))


line_down_color = (255,0,0)
line_up_color = (0,0,255)
pt1 =  [0, line_down];
pt2 =  [w, line_down];
pts_L1 = np.array([pt1,pt2], np.int32)
pts_L1 = pts_L1.reshape((-1,1,2))
pt3 =  [0, line_up];
pt4 =  [w, line_up];
pts_L2 = np.array([pt3,pt4], np.int32)
pts_L2 = pts_L2.reshape((-1,1,2))

pt5 =  [0, up_limit];
pt6 =  [w, up_limit];
pts_L3 = np.array([pt5,pt6], np.int32)
pts_L3 = pts_L3.reshape((-1,1,2))
pt7 =  [0, down_limit];
pt8 =  [w, down_limit];
pts_L4 = np.array([pt7,pt8], np.int32)
pts_L4 = pts_L4.reshape((-1,1,2))


fgbg = cv2.createBackgroundSubtractorMOG2(detectShadows = True)


kernelOp = np.ones((3,3),np.uint8)
kernelOp2 = np.ones((5,5),np.uint8)
kernelCl = np.ones((11,11),np.uint8)


font = cv2.FONT_HERSHEY_SIMPLEX
persons = []
max_p_age = 5
pid = 1

# Connect to the database
#connection = pymysql.connect(host='192.168.1.101',
                          #   user='root',
                           #  password='',
                           #  db='arduino',
                            # charset='utf8mb4',
                            # cursorclass=pymysql.cursors.DictCursor)
#try:
  ##  with connection.cursor() as cursor:
        # Create a new record
  #      sql = "INSERT INTO `people_inside` (`count_people`) VALUES (%d)"
 #       cursor.execute(sql, (cnt_down-cnt_up))
###    connection.commit()
#finally:
#    connection.close()







while(cap.isOpened()):

    ret, frame = cap.read()

    for i in persons:
        i.age_one() 
    fgmask = fgbg.apply(frame)
    fgmask2 = fgbg.apply(frame)

    
    try:
        ret,imBin= cv2.threshold(fgmask,210,255,cv2.THRESH_BINARY)
        ret,imBin2 = cv2.threshold(fgmask2,210,255,cv2.THRESH_BINARY)
        #Opening (erode->dilate) 
        mask = cv2.morphologyEx(imBin, cv2.MORPH_OPEN, kernelOp)
        mask2 = cv2.morphologyEx(imBin2, cv2.MORPH_OPEN, kernelOp)
        #Closing (dilate -> erode) 
        mask =  cv2.morphologyEx(mask , cv2.MORPH_CLOSE, kernelCl)
        mask2 = cv2.morphologyEx(mask2, cv2.MORPH_CLOSE, kernelCl)
        cv2.imshow('Background Substraction',mask2)
    except:
        print('EOF')
        print ('UP:',cnt_up)
        print ('DOWN:',cnt_down)
        #cur.execute('select * from count_people')
        #cur.fetchall()
        break
    
    
    _, contours0, hierarchy = cv2.findContours(mask2,cv2.RETR_EXTERNAL,cv2.CHAIN_APPROX_SIMPLE)
    for cnt in contours0:
        area = cv2.contourArea(cnt)
        if area > areaTH:
            
            
            M = cv2.moments(cnt)
            cx = int(M['m10']/M['m00'])
            cy = int(M['m01']/M['m00'])
            x,y,w,h = cv2.boundingRect(cnt)

            new = True
            if cy in range(up_limit,down_limit):
                for i in persons:
                    if abs(cx-i.getX()) <= w and abs(cy-i.getY()) <= h:
                        
                        new = False
                        i.updateCoords(cx,cy)   
                        if i.going_UP(line_down,line_up) == True:
                            cnt_up += 1;
                            cur.execute('UPDATE `people_inside` set people_count=people_count -1')
                            db.commit()
                            #f.write("%d "%(cnt_down-cnt_up))
                            
                           

               
                            #print "ID:",i.getId(),'crossed going up at',time.strftime("%c")
                        if i.going_DOWN(line_down,line_up) == True and area>2.0*areaTH:
                            cnt_down =cnt_down+1;
                            cur.execute('UPDATE `people_inside` set `people_count`=`people_count` +1')
                            db.commit()
                            #f.write("%d "%(cnt_down-cnt_up))
                        elif i.going_DOWN(line_down,line_up) == True:
                            cnt_down += 1;
                            cur.execute('UPDATE `people_inside` set `people_count`=`people_count` +1')
                            db.commit()
                            #f.write("%d "%(cnt_down-cnt_up))
                           # print "ID:",i.getId(),'crossed going down at',time.strftime("%c")
                        break
                    if i.getState() == '1':
                        if i.getDir() == 'down' and i.getY() > down_limit:
                            i.setDone()
                        elif i.getDir() == 'up' and i.getY() < up_limit:
                            i.setDone()
                    if i.timedOut():
                        
                        index = persons.index(i)
                        persons.pop(index)
                        del i     
                if new == True:
                    p = Person.MyPerson(pid,cx,cy, max_p_age)
                    persons.append(p)
                    pid += 1     
            
            #cv2.circle(frame,(cx,cy), 5, (0,0,255), -1)
            #img = cv2.rectangle(frame,(x,y),(x+w,y+h),(0,255,0),2)            
            #cv2.drawContours(frame, cnt, -1, (0,255,0), 3)
    
    #for i in persons:

        #cv2.putText(frame, str(i.getId()),(i.getX(),i.getY()),font,0.3,i.getRGB(),1,cv2.LINE_AA)
        
    
    str_up = 'OUTSIDE: '+ str(cnt_up)
    str_down = 'INSIDE: '+ str(cnt_down)
    frame = cv2.polylines(mask2,[pts_L1],False,(255,255,255),thickness=1)
    frame = cv2.polylines(mask2,[pts_L2],False,(255,255,255),thickness=1)
    frame = cv2.polylines(mask2,[pts_L3],False,(255,255,255),thickness=1)
    frame = cv2.polylines(mask2,[pts_L4],False,(255,255,255),thickness=1)
    cv2.putText(frame, str_up ,(10,40),font,0.5,(255,255,255),2,cv2.LINE_AA)
    cv2.putText(frame, str_up ,(10,40),font,0.5,(0,0,255),1,cv2.LINE_AA)
    cv2.putText(frame, str_down ,(10,90),font,0.5,(255,255,255),2,cv2.LINE_AA)
    cv2.putText(frame, str_down ,(10,90),font,0.5,(255,0,0),1,cv2.LINE_AA)

    cv2.imshow('Frame',frame)
  
    k = cv2.waitKey(30) & 0xff
    if k == 27:
        break

#f.close()

db.close()
cap.release()
cv2.destroyAllWindows()
