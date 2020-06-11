from rediscluster import RedisCluster as StrictRedisCluster
redis_nodes = [{'host':'127.0.0.1','port':6379},{'host':'127.0.0.1','port':6380}]
rc = StrictRedisCluster(startup_nodes=redis_nodes)
print(rc.info("server").keys())
