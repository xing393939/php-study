### 单元测试

#### 接口与测试
1. [契约 |《Laravel内核分析》](https://learnku.com/docs/laravel-kernel/contract/6920)
1. laravel的controller层与数据库层中间加一个抽象层，好处有：
  * controller层和数据库层隔离，controller层不需要依赖太多其他类
  * 方便mock数据和测试

#### 基本知识
1. [检查php和phpunit版本兼容性](https://phpunit.de/supported-versions.html)
1. 打开错误输出命令（默认测试用例的echo 是不打印的）：phpunit -v 或者 phpunit --verbose
1. 生成html报告命令：phpunit --coverage-html report
1. 指定测试：phpunit  --filter testRedPacketCheck

#### 模板方法
1. setUpBeforeClass： 测试用例类的第一个测试运行之前执行
1. tearDownAfterClass： 测试用例类的最后一个测试运行之后执行
1. setUp: 每个测试方法运行之前执行
1. tearDown： 每个测试方法运行之后执行

#### 依赖关系和数据提供器（测试方法的注解）
1. [PHP单元测试](https://myyphp.github.io/2018/05/02/PHP%E5%8D%95%E5%85%83%E6%B5%8B%E8%AF%95-%E4%B8%80-%E5%9F%BA%E7%A1%80/)
1. 依赖关系注解：@depends testOne表示将testOne的返回值当作传参使用
1. 数据提供器注解：@dataProvider dataProvider表示将dataProvider的返回值当作传参使用，第一维的元素为该函数参数列表

#### 基境(fixture)
1. [基境](https://phpunit.readthedocs.io/zh_CN/latest/fixtures.html)
1. setUp() 是创建测试所用对象的地方
1. tearDown() 是清理测试所用对象的地方

#### 测试替身之桩件(Stub)
1. [测试替身](https://phpunit.readthedocs.io/zh_CN/latest/test-doubles.html)
1. [PHPUnit单元测试对桩件（stub）和仿件对象（Mock）的理解](https://blog.csdn.net/loophome/article/details/52198716)
1. 创建桩件：$stub = $this->createMock(SomeClass::class)
1. 配置桩件：$stub->expects($this->any())->method('doSomething')->willReturn('foo')
1. 使用桩件：$this->assertEquals('foo', $stub->doSomething())

#### 测试替身之仿件对象(Mock)
1. [测试替身](https://phpunit.readthedocs.io/zh_CN/latest/test-doubles.html)
1. 仿件对象远不止是桩件加断言，它可以test测试对象某些方法是否被调用，调用多少次

#### 案例经验
1. [【phpunit】这样跑测试，竟然节省了我们 90% 的时间](http://lijinma.com/blog/2017/01/29/phpunit-optimizing/)
1. [使用桩件 (Stub) 解决 Laravel 单元测试中的依赖](https://segmentfault.com/a/1190000010605518)
1. 数据隔离的办法：1)事务回滚。2)migrate，数据库用sqlite

#### lumen 测试文档
1. [测试](https://learnku.com/docs/lumen/5.7/testing/2419)
1. 模拟登录：$this->actingAs($user)->get('/user')，前提条件是项目用Auth模块作为登录认证
1. 验证数据库的数据：$this->seeInDatabase('users', ['email' => 'sally@foo.com']);
1. 每次测试之后重置数据库，有两个方法：
  1. 迁移：Laravel\Lumen\Testing\DatabaseMigrations。每一个测试func开始前都migrate，结束时migrate:rollback。
  1. 事务：Laravel\Lumen\Testing\DatabaseTransactions。每一个测试func开始前都transaction begin，结束时transaction rollback。
1. 模型工厂，使用步骤为：
  1. 在database/factories下定义工厂（依赖Faker包生成各种随机数据以方便测试）
  1. 在测试用例中使用：$user = factory('App\User')->make();
  1. factory对象的make将创建一个新的模型供你在测试中使用，create将创建它并将其持久化到你的数据库中
1. 避免触发事件：
  1. $this->expectsEvents('App\Events\UserRegistered'); UserRegistered的处理事件将不会运行
  1. $this->withoutEvents(); 所有事件都不会运行
1. 模拟任务：$this->expectsJobs('App\Jobs\UserRegistered'); 只验证UserRegistered有没有派送，但是任务本身不执行
1. 模拟门面如Cache：Cache::shouldReceive('get')->once()->with('key')->andReturn('value')
1. 设置环境变量的两个方法：
  * 在phpunit.xml设置env，覆盖.env的配置
  * 在phpunit.xml设置env，仅设置APP_ENV=testing，然后在.env.testing中配置

#### FIRST原则
1. F-FAST(快速原则)：单元测试应该是可以快速运行的，在各种测试方法中，单元测试的运行速度是最快的，通常应该在几分钟内运行完毕
1. I-Independent(独立原则)：单元测试应该是可以独立运行的，单元测试用例互相无强依赖，无对外部资源的强依赖
1. R-Repeatable(可重复原则)：单元测试应该可以稳定重复的运行，并且每次运行的结果都是相同的
1. S-Self Validating(自我验证原则)：单元测试应该是用例自动进行验证的，不能依赖人工验证
1. T-Timely(及时原则）：单元测试必须及时的进行编写，更新和维护，以保证用例可以随着业务代码的变化动态的保障质量

#### AIR原则
1. A-Automatic(自动化原则)：单元测试应该是自动运行，自动校验，自动给出结果
1. I-Independent(独立原则)：单元测试应该是独立运行，互相之间无依赖，对外部资源无依赖，多次运行之间无依赖
1. R-Repeatable(可重复原则)：单元测试是可重复运行的，每次的结果都稳定可靠

#### 可测试性设计
1. [可测试性设计](https://fifsky.com/article/102)
1. 可重复执行原则：让时间这样的变量，通过传参的方式固定
1. Mock方法
1. 代码要遵守单一职责，如果参数数量为N，条件判断为M，那么我们至少需要N * M个单元测试用例才能覆盖我们的业务逻辑。最好是拆分成R个子单元，分别对这R个子单元测试。

#### 整洁架构
1. [关于整洁架构(clean architecture)的一些思考](https://fifsky.com/article/99)
1. 目前公司的Controller即可理解为是service业务层
1. 正常业务：Controller->Contract接口->repository数据层
1. 测试替身：Controller->Mock



















