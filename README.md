# Laravel 7 基础模板

开箱即用的 Laravel 7 基础结构。只需很少的代码即可快速构建出一个功能完善的高颜值系统。内置丰富的常用组件，开箱即用，让开发者告别冗杂的代码，对 RESTFul 开发者非常友好。

## 功能特性
- [x] 内置 laravel/passport 的授权机制；
- [x] 扩充 laravel/passport 短信验证码登录；
- [x] 扩充 laravel/passport 社交账户登录（App）；
- [x] 可选扩充 laravel/passport 微信登录、QQ登录、百度登录、头条登录（小程序）；
- [x] 高度完善的控制器、模型、模块模板；
- [x] 集成常用基础扩展；
- [x] 内置模型通用高阶 Traits 封装;
- [x] 自动注册 Policies；
- [x] 内置用户系统和基础接口；
- [x] 内置 `DcatAdmin` 管理后台；
- [x] 内置图形验证码；
- [x] 内置支持邮件验证码(需要Redis)；
- [x] 内置支持短信验证码(需要Redis)；
- [x] 无缝可选支持微信和支付宝交易；
- [x] 无缝可选支持App通知推送；
- [x] 无缝可选支持带签名的开放API接口；

## RESTFul

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/5e5655b5100a1eafc2f6)

## 环境
 - PHP >= 7.2.5
 - Fileinfo PHP Extension
 - Redis PHP Extension(短信、邮件验证码必须)
 
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

## 可选支持

### 签名的开放API接口
API签名访问，需要安装 https://github.com/larvacent/laravel-auth-signature-guard 

### 无缝可选支持App通知推送
https://github.com/larvacent/laravel-wechat-notification-channel
https://github.com/larvacent/laravel-umeng-notification-channel
https://github.com/larvacent/laravel-umeng-push

### 无缝可选支持微信和支付宝交易
https://github.com/larvacent/laravel-transaction

## License
------------
`dcat-admin` is licensed under [The MIT License (MIT)](LICENSE).
