# web-nginx项目介绍 #

nginx已成为发展速度最快的web及proxy服务器，如何管理众多服务的配置，和不断增多的应用需求。配置文件越来越复杂，每一次修改时都需要万分小心，服务器上在应用从十几个增涨到几十个。我开始分拆配置文件，使用include .vservice代替庞大的nginx.conf。使用svn来管理修改的配置文件的版本。如果开发一个类似smbind web管理程序，就可以方便的管理多台nginx服务器，并可以多人协作管理。
主要功能

项目开发模块 V1.0

services管理

将nginx中的主机（server）定义为一个services；

用户管理

支持多用户，用户分级为admin|user admin 用户可以管理所有nginx services, user 用户可以管理自己的nginx services;

upstreams管理

在web-nginx中可以增加/删除 upstream 中的 realserver，upstream生成使用模板生成，用户可以根据自己的需求修改模板来完成特殊需求的upstream.conf;

upstreams commands:

:upstream\_name: 指定upstream的名字

:upstream\_server\_list: upstream realserver列表

servers管理

配置nginx下的server\_name

:server\_name: 指定server\_name

locations管理

web-nginx支持增加/删除/修改 location ,location使用模板生成，用户可以根据自己的需求修改模板来完成特殊需求的location.conf;

locations commands:

:location\_path: 指定location名字

:alias: 指定路径别名

:root\_path: 指定主目录

:proxy\_pass: nginx做为代理，指定代理服务upstream

:proxy\_next\_upstream:设置upsteam 轮询错误

:access\_log: 设置本location的访问日志

:rewrite\_policy: 应用rewrite策略 rewrite\_policy管理 web-nginx支持增加/删除/修改 rewrite策略管理

配置文件下载客户端程序 web-nginx系统自带客户端下载程序，用户配置程序后会自动检索服务器上生成的配置文件并下载重起nginx服务。