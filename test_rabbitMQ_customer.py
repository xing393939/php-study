import pika
import time

credentials = pika.PlainCredentials('guest', 'guest')
connection = pika.BlockingConnection(pika.ConnectionParameters(host='172.28.21.149', port=5672,  credentials=credentials))
channel = connection.channel()

def callback(ch, method, properties, body):
    time.sleep(1)
    print (body)

def channel_for_exchange_direct():
    # 声明一个直连交换机E
    channel.exchange_declare(exchange='demo_exchange_direct', exchange_type='direct')
    # 声明一个Q
    channel.queue_declare(queue='demo_direct_q')
    # 将E和Q绑定
    channel.queue_bind(exchange='demo_exchange_direct', queue='demo_direct_q')
    # 这个Q接受消息，不带routingkey，因为直连交换机会将Q和key同名
    channel.basic_consume('demo_direct_q', callback)
    # 开始消费
    channel.start_consuming()

def channel_for_exchange_topic():
    channel.exchange_declare(exchange='demo_exchange_topic', exchange_type='topic')
    channel.queue_declare(queue='demo.topic_q')
    channel.queue_bind(exchange='demo_exchange_topic', queue='demo.topic_q', routing_key='demo.*')
    channel.basic_consume('demo.topic_q', callback)
    channel.start_consuming()

#channel_for_exchange_direct()
channel_for_exchange_topic()
