### IPC 相关

#### System V 和 POSIX 和 BSD
1. System V和BSD
  * [Unix/Linux的System V、BSD、Posix概念](https://blog.csdn.net/qq_29344757/article/details/78657874)
  * Unix操作系统在操作风格上主要分为System V和BSD，Linux的操作风格介于二者之间
  * Socket编程有BSD socket和System V的TLI，不过后者已经被淘汰
1. POSIX 的全称是Portable Operating System Interface
  * [中文文档](https://riptutorial.com/zh-CN/posix)
  * [糟糕的 POSIX IO](http://guleilab.com/2019/05/12/bad-posix-io/)，因为POSIX IO是有状态的，因此有瓶颈
  * 与System V IPC 接口不同，POSIX IPC接口均为多线程安全接口
  * POSIX信号量是基于内存的，即信号量值是放在共享内存中的；System v信号量测试基于内核的，它放在内核里面，要使用System V信号量需要进入内核态

#### PHP的扩展
1. System V IPC：sysvmsg 消息队列；sysvsem 信号量；sysvshm 共享内存
1. BSD IPC：socket(stream)
1. POSIX IPC：posix 支持消息队列、信号量、共享内存
1. pcntl 扩展：提供进程相关操作函数
1. shmop 扩展：，基于System V IPC接口，共享内存操作扩展。与sysvshm的区别在于是比特级别的控制，内存使用率比sysvshm高，属于高手进阶方式











