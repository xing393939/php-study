### Composer自动加载源码分析

#### 加载的文件
1. vendor/autoload.php，入口文件
1. vendor/composer/autoload_real.php，主文件
1. vendor/composer/ClassLoader.php，处理psr0、psr4、classMap、files的类
1. vendor/composer/autoload_static.php，提供psr0、psr4、classMap、files

#### 处理流程
1. autoload_real.php中会实例一个ClassLoader
1. autoload_real.php中将autoload_static的元素set到ClassLoader
  1. zend_loader_file_encoded，判断没有zend加密就只加载autoload_static.php（一般都走这个）
  1. 否则就加载autoload_namespaces.php、autoload_psr4.php、autoload_classmap.php、autoload_files.php
1. psr0、psr4、classMap会提供spl_autoload_register注册加载方法
1. files会直接include

#### composer配置说明
1. require是直接用第三方包，autoload是引用本地的
1. require-dev 和 autoload-dev 只在根包起作用
  * 假设A包的composer配置了require-dev，此时B包配置使用A包，A包的require-dev部分是无法用的。
1. 执行了composer dumpautoload后，classmap会包含psr0和psr4的对应关系：https://stackoverflow.com/questions/22803419