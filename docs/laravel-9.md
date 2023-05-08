### 核心组件分析

```
\Cache::rememberForever("key", null);
1. 通过config/app.php找到Cache的alias：Illuminate\Support\Facades\Cache::class
1. 找到cache绑定的实现：\Illuminate\Cache\CacheManager::class（服务提供者是CacheServiceProvider）
1. 它的__call方法是：$this->store()->$method(...$parameters);
1. $this->store()是$this->createFileDriver()，最终是$this->repository(new FileStore())

\Mail::to($user)->send(null);
1. config/app.php的MailServiceProvider里面绑定了mailer的实现：
  * mailer对应\Illuminate\Mail\Mailer::class
  * swift.mailer对应\Swift_Mailer::class
  * swift.transport对应\Illuminate\Mail\TransportManager::class。通过$this['app']['config']['mail']['driver']选取引擎
1. 通过config/app.php找到Mail的alias：Illuminate\Support\Facades\Mail::class
1. 找到mailer绑定的实现：\Illuminate\Mail\Mailer::class（服务提供者是MailServiceProvider）
1. 它的to方法是：new PendingMail($this)
1. send方法最终对应Illuminate\Mail\Mailable->send()

\Redis::set("key", null)
1. 通过config/app.php找到Redis的alias：Illuminate\Support\Facades\Redis::class
1. 找到redis绑定的实现：\Illuminate\Redis\RedisManager::class（服务提供者是RedisServiceProvider）
1. 它的__call方法是：$this->connection()->$method(...$parameters);
1. $this->connection()是$this->resolve()，最终是$this->connector()
1. config/database.php的redis.client决定了是使用pgpredis还是predis
```



























