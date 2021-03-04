import pika
import time

credentials = pika.PlainCredentials('guest', 'guest')
connection = pika.BlockingConnection(pika.ConnectionParameters(host='172.28.21.149', port=5672,  credentials=credentials))
channel = connection.channel()

def send_to_exchange_direct():
    # 声明一个直连交换机E
    channel.exchange_declare(exchange='demo_exchange_direct', exchange_type='direct')
    # 由于往直连交换机带routing_key发送消息，会被自动转发给 与该E绑定的且与routing_key同名的Q
    channel.basic_publish(
                          exchange='demo_exchange_direct',
                          routing_key='demo_direct_q',
                          body="hello world")

def send_to_exchange_topic():
    channel.exchange_declare(exchange='demo_exchange_topic', exchange_type='topic')
    channel.basic_publish(
                          exchange='demo_exchange_topic',
                          routing_key='demo.topic',
                          body="hello topic")
send_to_exchange_topic()