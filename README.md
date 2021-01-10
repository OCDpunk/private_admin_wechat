# private_admin_wechat

个人管理系统微信服务，需要配合https://github.com/OCDpunk/private_admin 使用。
:x: 功能未全部实现，施工中 :construction:

## 系统环境

- PHP: 7.3+
- Mysql:5.7+（mysql8暂时未测）

## 安装项目

1. 打开终端，使用`composer install`安装依赖包。

2. 使用`cp .env.example .env`复制配置文件，根据自己的环境配置。

3. 使用`php artisan key:generate`创建随机秘钥。
