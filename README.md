# Moe-counter
一个PHP+Mysql版本的计数器

![Moe-counter](https://count.getloli.com/get/@Moe-counter.github)

本项目是基于 [https://github.com/journey-ad/Moe-counter](Github@journey-ad/Moe-counter) 制作的PHP + Mysql版本

使用说明：
修改文件 Class/Mysql.class.php 内的数据库连接信息
修改文件 Class/Config.class.php 内的站点链接

Nginx伪静态:
location / {  
	rewrite  ^/get/@(.*)$  /get.php?name=$1  last;
}  

Apache伪静态暂无，自行研究谢谢
