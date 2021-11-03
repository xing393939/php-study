import math
import random

# 算低位零的个数
def low_zeros(value):
    for i in range(1, 32):
        if value >> i << i != value:
            break
    return i - 1

# 通过随机数记录最大的低位零的个数
class BitKeeper(object):

    def __init__(self):
        self.maxbits = 0

    def random(self):
        value = random.randint(0, 2**32-1)
        bits = low_zeros(value)
        if bits > self.maxbits:
            self.maxbits = bits

class Experiment(object):

    def __init__(self, n):
        self.n = n
        self.keeper = BitKeeper()

    def do(self):
        for i in range(self.n):
            self.keeper.random()

    def debug(self):
        print(self.n, '%.2f' % math.log(self.n, 2), self.keeper.maxbits)

exp = Experiment(100000)
exp.do()
exp.debug()