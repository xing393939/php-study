import pprint
from redis.sentinel import Sentinel
sentinel = Sentinel([('127.0.0.1', '26379')])
master = sentinel.discover_master("doge-master")
slaver = sentinel.discover_slaves("doge-master")
pprint.pprint(master)
pprint.pprint(slaver)

master = sentinel.master_for("doge-master")
slaver = sentinel.slave_for("doge-master")
pprint.pprint(master.set("a", 1))
pprint.pprint(slaver.info("server").get("tcp_port"))
