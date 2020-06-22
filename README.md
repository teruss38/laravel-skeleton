# Laravel 7 基础模板

开箱即用的 Laravel 7 基础结构。

## 特点
- 内置 laravel/passport 的授权机制；
- 扩充 laravel/passport 短信验证码登录；
- 扩充 laravel/passport 社交账户登录（App）；
- 高度完善的控制器、模型、模块模板；
- 集成常用基础扩展；
- 内置模型通用高阶 Traits 封装;
- 自动注册 Policies；
- 内置用户系统和基础接口；
- 内置DcatAdmin管理后台；
- 内置支持邮件验证码；
- 内置支持短信验证码；

## RESTFul
    [![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/5e5655b5100a1eafc2f6)
## 安装

1. 创建项目

```bash
$ composer create-project larvacloud/laravel-skeleton:dev-master -vv
```


2. 创建配置文件

```bash
$ cp .env.develop .env
```

3. 创建数据表和测试数据

```bash
$ php artisan migrate --seed
```

然后访问 `http://laravel-skeleton.test/` 将会看到网站信息。 
