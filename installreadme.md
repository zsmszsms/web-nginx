# web-nginx v1.0安装说明 #
web-nginx 安装环境：
php5 + mysql5
## 1>配置数据库 ##
create database nginx\_conf
打开nginx\_conf\_msyql.sql
创建nginx\_conf\_mysql.sql中的表
## 2>拷贝程序到httpd目录 ##
## 3>安装pear db ##
pear install db
## 4>配置config.php ##
$_CONF['peardb\_path']="/usr/share/pear";
// Database DSN.
$_CONF['db\_type']="mysql";
$_CONF['db\_user']="username";
$_CONF['db\_pass']="password";
$_CONF['db\_host']="localhost";
$_CONF['db\_db']="nginx\_conf";
//Nginx conf temp dir
$_CONF['conf\_temp']="/tmp";
$_CONF['conf\_dir']="config\_dir/";
$_CONF['commit\_log']="commitlog/commitlog.log";
$_CONF['md5\_file']="commitlog/md5\_file.log";
$