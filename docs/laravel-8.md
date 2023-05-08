### CSRF和XSRF

#### 跨站脚本攻击
1. 当用户访问黑客的站点时，诱导用户点击或者提交a.com/transferMoney?to=hacker&money=900
1. 诱导的时候也可以使用post，所以a.com需要检查origin和referer，最好还加上CSRF字段在header头或者post域

#### laravel的CSRF、XSRF
1. [laravel的csrf token 的了解及使用](https://www.cnblogs.com/zhuchenglin/p/7723997.html)
1. [what is the difference between X-XSRF-TOKEN and X-CSRF-TOKEN](https://stackoverflow.com/questions/42408177)
1. laravel的web项目默认使用CSRF，api项目使用XSRF
1. web项目：
  * CSRF直接存input域或者页面meta中
  * 校验的时候判断是不是ajax提交，是则检查header头X-CSRF-TOKEN，否则检查post字段_token
1. api项目：
  * laravel默认在每个请求都加上了名为x-csrf-token的cookie（x-csrf-token其实就是CSRF的加密值，因为laravel的cookie默认是加密的）
  * 校验的时候校验header头X-XSRF-TOKEN

#### CSRF的生成和校验
* LearnKu网站是把CSRF存在cookie，每次ajax请求都会修改cookie
* CSRF的生成：需要借助session(所以还需要一个cookie存session_id)，生成csrf存session，再把加密的csrf返回
* CSRF的校验：先解密csrf，再和session中的csrf对比。校验完后重新生成csrf返回。


























