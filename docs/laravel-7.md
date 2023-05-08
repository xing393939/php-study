### 核心容器类的使用

#### 参考资料
1. [借鉴laravel打造一套微服务化框架](https://sunnyingit.github.io/book)

#### 容器的绑定方式：
1. instance($abstract, $instance)：直接绑定实例化好的value
2. bind($abstract, $concrete, $shared)：绑定可以实例化的匿名函数
3. singleton：单例绑定可以实例化的匿名函数，等价于bind($abstract, $concrete, true)
4. bindIf：在bind前判断是否绑定过，避免重复绑定

#### 容器事件：
1. $app->resolving(闭包)，解析任何对象都会调用
2. $app->resolving(XXX::class, 闭包)，解析XXX时调用
3. $app->afterResolving(闭包)，解析完任何对象都会调用
4. $app->afterResolving(XXX::class, 闭包)，解析完XXX时调用

#### 容器call方法
1. $app->call('simpleFunction')，直接调用方法名
2. $app->call("TestClass@func")，先实例化类，再调用类方法
3. $app->call($instance)，调用实例，默认调用__invoke方法
4. $app->call([$instance, "func"])，调用实例的方法
5. $app->call([$instance, "staticFunc"])，调用实例的静态方法
6. $app->call(["TestClass", "staticFunc"])，调用类的静态方法
7. $app->call("TestClass::staticFunc")，调用类的静态方法

#### 容器上下文绑定：
1. $app->when(PhotoController::class)->needs(Filesystem::class)->give(LocalFilesystem::class)
2. $app->when(PhotoController::class)->needs(Filesystem::class)->give("s3")


























