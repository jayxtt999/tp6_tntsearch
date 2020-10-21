ThinkPHP 6.0 使用 tntsearch 实现轻量级搜索
===============

### 安装 tntsearch
`composer install` or
`composer require teamtnt/tntsearch`
### 运行
cd  ./public &&  php -S 127.0.0.1:1234 或者apache nginx套件

### 创建索引
`php think create_index` or `curl 127.0.0.1:1234/init`

### 新建索引
`php think add_index`

### 查询与索引配置

`/config/tnt_index.php`

### 查询

`curl http://127.0.0.1/search?key=xxxx` 


 `tntsearch` 初始化的位置为 `app\service\TntService`

 
 
 ### 前端
 
 `https://github.com/lzwme/bootstrap-suggest-plugin`
