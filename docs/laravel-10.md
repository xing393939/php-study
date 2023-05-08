### 业务层的事件、队列、模型Observer、模型Notifications、模型Policy

#### 事件
1. [Laravel 事件系统用法总结](https://learnku.com/articles/13515)
1. 举例，处理用户注册(register)功能的时候，我们经常会把发送欢迎邮件和订阅新闻简报的逻辑紧密耦合到了register方法里， 根据关注点分离原则，register方法不应该关心发送欢迎邮件和订阅新闻简报的具体实现。提供事件的监听和接收就可以解耦。
1. 使用方法如下：
  1. php artisan make:event UserRegistered和php artisan make:listener SendWelcomeMail --event=UserRegistered
  1. 触发事件：event(new UserRegistered($user));
  1. 处理事件：在SendWelcomeMail的handle()中处理
  1. 处理事件(异步处理)：
    * SendWelcomeMail需要继承ShouldQueue，把事件存入队列
    * php artisan queue:work，这个时候才会调用SendWelcomeMail的handle()
  
#### 队列
1. [Laravel 队列基本操作](https://learnku.com/articles/28872)  
1. [Laravel 的消息队列剖析](https://learnku.com/articles/4169)
1. 延迟队列使用了三个队列：
  1. queue:default:delayed  // 存储延迟任务
  1. queue:default          // 存储未处理任务
  1. queue:default:reserved // 存储待处理任务
1. 使用方法如下：
  1. 创建队列类：php artisan make:job Demo，类要继承ShouldQueue
  1. 生成队列：Demo::dispatch($args);
  1. php artisan queue:work，这个时候才会调用Demo的handle()

  
#### 模型Observer
1. [Laravel 中的模型事件与 Observer](https://learnku.com/articles/6657)
1. Eloquent 的操作会产生模型事件，我们可以通过添加"模型Observer"来做一些业务处理。添加"模型Observer"是基于laravel的事件的。
1. 使用方法如下：
  1. php artisan make:observer UserObserver --model=User
  1. 在 AppServiceProvider 类的boot()中注册User::observe(UserObserver::class);
     
#### 模型Notifications
1. 个人认为"模型Notifications"是"模型Observer"的子集，是一套消息通知系统，通知频道有数据库、邮件、短信等。
1. [Laravel 文档-消息通知](https://learnku.com/docs/laravel/7.x/notifications/7489)
1. 使用方法如下：
  1. php artisan make:notification UserNotification
  1. 调用方法1：$user->notify(new UserNotification($args)); notify方法是模型自带的
  1. 调用方法2：\Notification::send($user, new UserNotification($args));
1. 如果要把消息队列化，UserNotification需要继承ShouldQueue，并使用Queueable的trait

#### 模型Policy
1. [Laravel Policy 使用](https://learnku.com/articles/9275)
1. 建议用户授权就用"模型Policy"而不要用门面Gate类
1. 使用方法如下：
  1. php artisan make:policy PostPolicy
  1. laravel 5.8以下的版本需要在AuthServiceProvider类的$policies属性注册PostPolicy
  1. 在控制器中使用：$this->authorize('update', $post);
  1. 在视图中使用：@can("update", $post)


           



