# coding:utf-8
# 生产者
def producer(c):
    # 其他代码
    i = 0
    while i < 5:
        i += 1
        value = i
        c.send(value)

# 消费者
def consumer():
    # 其他代码
    while True:
        value = yield
        print(value)


c = consumer()
c.next()
producer(c)
