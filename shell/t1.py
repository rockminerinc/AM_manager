import urllib
import re
import json
import sys
import argparse
import socket
import threading
import datetime,time
import Queue

from argparse import RawTextHelpFormatter


parser = argparse.ArgumentParser(description='Controller Configuration\r\nDepends on module "requests":sudo easy_install requests',epilog='e.g. : python config.py -r 100 -s 1 -e 100 -u 192.168.0.2 -p 8334 -w tank_1',formatter_class=RawTextHelpFormatter)
parser.add_argument("-r", "--rack", help="192.168.rack.start~end",required=True,action="store")
parser.add_argument("-s", "--start", help="192.168.rack.start~end",required=True,action="store")
#parser.add_argument("-o", "--output", help="192.168.rack.start~end",required=True,action="store")

parser.add_argument("-e", "--end", help="192.168.rack.start~end",required=True,action="store")

if len(sys.argv)==1:
    parser.print_help()
    sys.exit(1)

args = parser.parse_args()

rack  = args.rack
start = args.start
end   = args.end


def getHtml(url):
    socket.setdefaulttimeout(9.0)
    page = urllib.urlopen(url) 
    html = page.read() 
    page.close() 
    return html


def getBoards(html):
    reg='<font face="courier new" size=2 color=white><br>.*?<br><br><input type="button" value="ReSession"'
    match = re.compile(r'<font face="courier new" size=2 color=white><br>(.*?)<br><br><input type="button" value="ReSession"')
    boards= re.findall(match,html)
    return str(len(boards[0].split('<br>')))

def getPoolData(html):
    match = re.compile(r'<font face="courier new" size=2 color=black><h3>(.*?)</h3>')
    data = re.findall(match,html)
    data2 = data[0].replace('<br>',',')
    data2 = data2.replace(' ','')
    data3 = data2.split(',')	
    return data3


ips=range(int(start),int(end)+1)


class ThreadClass(threading.Thread):
    def __init__(self,queue):
        threading.Thread.__init__(self)
        self.queue = queue
        
    def run(self):
        filename='tone-rack'+str(rack)+'.txt'
        file = open('/usr/share/nginx/www/data/'+filename,'wb+')

        while True:
            host = self.queue.get()
            try:
               # url = 'http://192.168.' +str(rack)+'.'+str(ip)+':8000'
                url = 'http://'+host+':8000'
                doc = getHtml(url)
                boards = 'boards:'+ getBoards(doc)
                data = getPoolData(doc)
                data.append(boards)
                mip = host # 'ip:192.168.'+ str(rack) +'.'+ str(ip)
                data.append(mip)
                result =  json.dumps(data)
                file.write(result+'\n')
            except(KeyboardInterrupt, SystemExit):   
                print '\nProgram Stopped Manually!';
                raise;
            except:
                print "Cannot connect to  "+str(host)
                continue
            self.queue.task_done()
            print '2'
#           thread.exit()

        file.close()
        print '1'
       # sys.exit(0)
	


def main():
    queue = Queue.Queue()
    for i in ips:
        t = ThreadClass(queue)
        t.setDaemon(True)
        t.start()
        
    for ip in ips:
        host='192.168.'+str(rack)+'.'+str(ip)
        queue.put(host)

    queue.join()

if __name__=='__main__':
    
    #st = time.time()
    main()
    print 'ok'
    #os._exit(0)
    #print '%f'%(time.time()-st)
