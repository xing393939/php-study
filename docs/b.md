### Linux init管理器

#### System V、Upstart、Systemd
1. [使用ps、rpm、/sbin/init命令查看Linux系统管理器程序](https://ywnz.com/linuxml/3554.html)
1. [System V 與 Upstart](http://benjr.tw/38611)
1. 查看运行的系统管理器：ps -p1 | grep -E "init|upstart|systemd"
1. centOS下查看运行的系统管理器：/sbin/init --version 或 rpm -qf /sbin/init
1. System V：使用运行级别（单用户、多用户、其他级别）和链接（位于/etc /rc?.d目录中，分别链接到/etc/init.d中的init脚本）来启动和关闭系统服务
1. Upstart：是基于事件的系统，它使用事件来启动和关闭系统服务。
  * /etc/init/*.conf 定義了哪些服務應該在何级别需要被執行
  * 它用于 Ubuntu 9.10 到 14.10 版本和基于 RHEL 6 的系统中，之后的被 systemd 取代了。
1. Systemd：配置文件主要放在 /usr/lib/systemd/system 目录，也可能在 /etc/systemd/system 目录
  * 支持并行化任务；
  * 同时采用 socket 式与 D-Bus 总线式激活服务；
  * 按需启动守护进程（daemon）；
  * 利用 Linux 的 cgroups 监视进程；
  * 支持快照和系统恢复；
  * 维护挂载点和自动挂载点；
  * 各服务间基于依赖关系进行精密控制。

|对比项  |System V	|Upstart  |Systemd |
| ---   | ---       | ---     | ---    |
|使某服务自动启动	   |chkconfig –level 3 sshd on | 	|systemctl enable sshd.service |
|使某服务不自动启动  |chkconfig –level 3 sshd off|	|systemctl disable sshd.service|
|检查服务状态	   |service sshd status	     |     |systemctl status sshd.service |
|显示所有已启动的服务|chkconfig –list	        |initctl list |systemctl list-units –type=service|
|启动某服务	       |service sshd start	    |start sshd   |systemctl start sshd.service      |
|停止某服务	       |service sshd stop	    |stop sshd    |systemctl stop sshd.service       |
|重启某服务	       |service sshd restart	|restart sshd |systemctl restart sshd.service    |












