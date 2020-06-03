## 博客介绍

### 环境要求
```
Laravel 6.X
PHP 7.2+
Mysql 5.7+
Redis 5.0+
```
### 主要功能
* 文章
    * 集成 Markdown 编辑器，支持拖拽上传图片
    * 多标签选择器
    * 支持全文检索
    * 可分专题发布文章
    * 代码高亮
    * 支持分类、打标签
* 评论
    * 支持多级嵌套评论
    * 收到评论/回复后站内通知

* 用户
    * 支持GitHub登录
    * 站长登录前/后台，同步前/后台登录状态
    
* 管理后台
    * 站点信息可配置
    
 ### 项目信息
 * 代码地址：https://github.com/HubQin/QinBlog
 * Demo地址：https://blog.ishare.cool/


## 博客部署

### 下载代码
```
https://github.com/HubQin/QinBlog.git blog
```

### Laravel 配置

* 创建`.env`文件
```
cp .env.example .env
```
* 配置`.env`文件如下：


```
APP_NAME=Larashop  # <-- 应用名
APP_ENV=production # <-- 运行环境
APP_KEY= # <-- 后面将运行命令生成
APP_DEBUG=false # <-- 关闭调试（部署过程方便调试可先设为true）
APP_URL=xxxx.xxx #  <-- 你的网站地址

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=mysql # <-- mysql主机，注意是填MySQL在docker-compose中的服务名
DB_PORT=3306
DB_DATABASE=myblog # <-- 数据库名称
DB_USERNAME=root   # <-- 数据库用户名
DB_PASSWORD=xxxxxx # <-- 数据库密码，填写在docker-compse.yml文件中设置的密码

BROADCAST_DRIVER=log
CACHE_DRIVER=redis # <-- 缓存驱动
QUEUE_CONNECTION=redis # <-- 队列驱动
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=redis # <-- redis主机，填写规则同mysql
REDIS_PASSWORD=xxxxxx # <-- 填写在 redis.conf中设置的密码（requirepass），没设置则不用写
REDIS_PORT=6379

# 暂时没用到邮箱，可不配置
MAIL_DRIVER=smtp
MAIL_HOST=smtp.qq.com
MAIL_PORT=465
MAIL_USERNAME=xxxxxx@qq.com # <-- 你的邮箱
MAIL_PASSWORD=xxxxxx # <--从邮箱服务商获取的密码
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=xxxxxx@qq.com # <-- 你的邮箱
MAIL_FROM_NAME=Larashop # <-- 应用名
```
* 创建数据库，名称与`.env`中`DB_DATABASE`的值相同

* 安装依赖
```
composer install --no-dev --prefer-dist --optimize-autoloader
```
* 生成KEY
```
php artisan key:generate
```
* 创建软链接
```
php artisan storage:link

```

* 数据表迁移
```
php artisan migrate --force

```
* 创建软连接
```
php artisan storage:link
```
* 生成配置、路由、事件缓存
```
php artisan route:cache
php artisan config:cache
php artisan event:cache
```
* 导入后台菜单和角色数据

    在数据库运行`/database/admin-menu-and-role-data.sql`文件
* 发布管理后台资源文件
```
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
```
* 创建后台管理员账号

    运行 `php artisan admin:create-user`，依照提示输入管理员名称、密码等

### Nginx 配置

可参考官网配置：https://laravel.com/docs/7.x/deployment#nginx

需要更完善的配置，入配置HTTPS，更多安全配置等，可参考我的另一篇文章：https://learnku.com/articles/40979

### Supervisor 进程监护配置
关于 Supervisor 的使用，可以参考我之前写的这篇：https://learnku.com/articles/36939

参考配置：
```
[program:qin]
process_name=%(program_name)s_%(process_num)02d
directory=/var/www/html/qin
command=php artisan queue:work --tries=3 --sleep=3 --daemon
autostart=true
autorestart=true
numprocs=1
user=root
stopasgroup=true
killasgroup=true
redirect_stderr=true
stdout_logfile=/var/www/html/qin/storage/logs/queue.log
```

### 解决文件权限问题
* 日志和缓存权文件限
```
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache

chmod -R 775 storage
chmod -R 775 bootstrap/cache
```
* 全文检索数据文件权限

    由于最开始你发表文章时，索引是由队列生成的，而队列有可能是root账号生成的，这可能导致web访问的账号无法修改该文件。所以，部署完成后发表一篇文章
在`storage/indices`目录会有`posts.index`文件，在项目根目录下运行`chmod 0777 storage/indices/posts.index`，给予最高权限。
* 站点配置文件`config/site`也要给予最高权限，因为管理后台配置站点要修改到这个文件。

### iconfont 图标设置

   分类图标使用了iconfont。配置方法：登录https://www.iconfont.cn/创建一个项目，选择图标到购物车后，添加到项目。进入“我的项目”，选择“Symbol”类型，复制 .js 后缀的 url，到管理后台--站点配置，填入对应的输入框，然后保存即可。
## 主要功能展示
