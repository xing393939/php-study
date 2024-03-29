### 入口文件分析

### 说明
1. 本系列基于laravel 7.30.3
1. [laravel 核心组件分析](https://sunnyingit.github.io/book)
1. [看懂UML类图和时序图](https://design-patterns.readthedocs.io/zh_CN/latest/read_uml.html)
1. [Laravel内核分析](https://learnku.com/docs/laravel-kernel)
1. [详解 Laravel 源码中优秀的设计模式 - 掘金小册](https://juejin.cn/book/6844733703516585997)

#### public/index.php
1. bootstrap/app.php，创建服务容器$app，单例绑定Http、Console、Exceptions服务
  1. registerBaseBindings()，instance绑定Container，单例绑定Mix、PackageManifest
  1. registerBaseServiceProviders()，三大基础服务provider：Event、Log、Routing
  1. registerCoreContainerAliases()，注册服务别名：如app、auth、cache、config、cookie、db、events、files、log、redis、session
1. 实例化Http服务，它依赖了Router服务(也被实例化)
1. Http服务：$response=Http->handle(Request)
  1. handle()包含sendRequestThroughRouter()
  1. 包含bootstrap()，执行6个服务：
    * LoadEnvironmentVariables
    * LoadConfiguration
    * HandleExceptions
    * RegisterFacades
    * RegisterProviders
    * BootProviders
  1. 包含(new Pipeline())->send()->through()->then()，5大中间件
    * CheckForMaintenanceMode，检查 artisan down
    * ValidatePostSize，验证 POST 数据大小
    * TrimStrings，trim $_GET 和 $_POST
    * ConvertEmptyStringsToNull，$_GET 和 $_POST 的元素若为''则置为null
    * TrustProxies，设置受信任的代理
1. 执行$response->send()
1. Http服务：terminate()收尾工作，中间件、容器的收尾工作


