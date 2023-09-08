### CSRF和XSRF

#### 跨站请求伪造
1. 当用户访问黑客的站点时，诱导用户点击或者提交a.com/transferMoney?to=hacker&money=900
1. 诱导的时候也可以使用post，所以a.com需要检查origin和referer，最好还加上CSRF字段在header头或者post域

#### laravel的CSRF、XSRF
* [CSRF 保护](https://learnku.com/docs/laravel/10.x/csrf/14847)
* CSRF的防范方案有
  1. 同源检测：Origin 和 Referer 验证
  2. Token验证：请求的token放header头或者post域，需定期更换
  3. 双重Cookie验证：请求的token要和cookie里的token相等，token可以由客户端生成
  4. Samesite Cookie：通常3和4一起使用
* laravel框架使用的方案2。请求中如何加上token：
  1. 放在html的每个表单中名为_token的隐藏域
  2. X-CSRF-TOKEN：放在meta标签，ajax请求时放在header头X-CSRF-TOKEN 
  3. X-XSRF-TOKEN，放在cookie中，ajax请求时放在header头X-XSRF-TOKEN

#### CSRF的生成和校验
* LearnKu网站是把CSRF存在cookie，每次ajax请求都会重新生成cookie
* CSRF的生成：先生成csrf存session，再设置名为csrf的cookie
* CSRF的校验：先解密csrf，再和session中的csrf对比。校验完后再设置名为csrf的cookie


























