#coding:utf-8
import socket

msgs = [ b'This is the message. ',
         b'It will be sent ',
         b'in parts.',
         ]
SERVER_ADDRESS = 'localhost'
SERVER_PORT = 8081

# Create a few TCP/IP socket
socks = [ socket.socket(socket.AF_INET, socket.SOCK_STREAM) for i in range(5) ]
# Connect the socket to the port where the server is listening
print('connecting to %s port %s' % (SERVER_ADDRESS,SERVER_PORT))
for s in socks:
    s.connect((SERVER_ADDRESS,SERVER_PORT))

for message in msgs:
    # Send messages on both sockets
    for s in socks:
        print('%s: sending "%s"' % (s.getsockname(), message) )
        s.send(message)

    # Read responses on both sockets
    for s in socks:
        data = s.recv(1024)
        print( '%s: received "%s"' % (s.getsockname(), data) )
        if not data:
            print(sys.stderr, 'closing socket', s.getsockname() )