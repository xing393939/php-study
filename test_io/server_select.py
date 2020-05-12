#coding:utf-8
import select
import socket
import Queue

server = socket.socket()
HOST = 'localhost'
PORT = 8081
print("start up %s on port: %s"% (HOST,PORT))
server.bind((HOST,PORT))
server.listen(10)
#不阻塞
server.setblocking(False)

msg_dic_queue = {}  #这是一个队列字典，存放要返回给客户端的数据
inputs = [server]   #inputs里存放要让内核监测的连接，这里的server是指监测server本身的连接状态
outputs = []        #outputs里存放要返回给客户端的数据连接对象

while True:
    print("waiting for next connect...")
    #如果没有任何fd就绪，程序就会一直阻塞在这里
    readable,writeable,exceptional = select.select(inputs,outputs,inputs)
    for r in readable:  #处理活跃的连接，每个r就是一个socket连接对象
        if r is server: #代表来了一个新连接
            conn,client_addr = server.accept()
            print("arrived a new connect: ",client_addr)
            conn.setblocking(False)
            """
            因为这个新建立的连接还没发数据来，现在就接收的话，程序就报异常了
            所以要想实现这个客户端发数据来时server端能知道，就需要让select再监测这个conn
            """
            inputs.append(conn)
            #初始化一个队列，后面存要返回给客户端的数据
            msg_dic_queue[conn] = Queue.Queue()
        else:   #r不是server的话就代表是一个与客户端建立的文件描述符了
            #客户端的数据过来了，在这里接收
            data = r.recv(1024)
            if data:
                print("received data from [%s]: "% r.getpeername()[0],data)
                #收到的数据先放到队列字典里，之后再返回给客户端
                msg_dic_queue[r].put(data)
                if r not in outputs:
                    #放入返回的连接队列里。为了不影响处理与其它客户端的连接，这里不立刻返回数据给客户端
                    outputs.append(r)
            else:   #如果收不到data就代表客户端已经断开了
                print("Client is disconnect",r)
                if r in outputs:
                    outputs.remove(r)   #清理已断开的连接
                inputs.remove(r)
                del msg_dic_queue[r]

    for w in writeable: #处理要返回给客户端的连接列表
        try:
            next_msg = msg_dic_queue[w].get_nowait()
        except:
            print("client [%s]"% w.getpeername()[0],"queue is empty...")
            outputs.remove(w)   #确保下次循环时writeable不返回已经处理完的连接
        else:
            print("sending message to [%s]"% w.getpeername()[0],next_msg)
            w.send(next_msg)    #返回给客户端源数据

    for e in exceptional:   #处理异常连接
        if e in outputs:
            outputs.remove(e)
        inputs.remove(e)
        del msg_dic_queue[e]