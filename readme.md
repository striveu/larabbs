<h1 align="center">Welcome to LaraBBS 👋</h1>
<p>
<img alt="Version" src="https://img.shields.io/badge/version-1.0.0-blue.svg?cacheSeconds=2592000" />
<a href="larabbs.strive.net.cn">
<img alt="Documentation" src="https://img.shields.io/badge/documentation-yes-brightgreen.svg" target="_blank" />
</a>
<a href="License Url">
<img alt="License: License" src="https://img.shields.io/badge/License-License-yellow.svg" target="_blank" />
</a>
<a href="https://twitter.com/Twitter">
<img alt="Twitter: Twitter" src="https://img.shields.io/twitter/follow/Twitter.svg?style=social" target="_blank" />
</a>
</p>

> A forum project base on Laravel 5.8

### 🏠 [Homepage](larabbs.strive.net.cn)

## Install

1. 克隆源代码：`git clone https://github.com/zhaiyuxinn/larabbs.git`
2. 环境配置：
	* `Homestead`
		* 运行以下命令编辑 `Homestead.yaml` 文件：`homestead edit`
		* 加入对应修改，如下所示：
	   ```
		 folders:
			 - map: ~/my-path/larabbs/    # 你本地的项目目录地址
				to: /home/vagrant/larbbs
		sites:
			- map: larabbs.test
			  to: /home/vagrant/larabbs/public
		 databases:
			 - larabbs
		 ``` 

	 * 修改完成后保存，然后执行以下命令应用配置信息修改：`homestead provision`
 > 注意：有些时候你需要重启才能看到应用。运行 `homestead halt` 然后 `homestead up` 进行重启。
 
 * `Laradock`
	 * 进入 `Laradock` 目录，运行 `docker-compose up -d mysql nginx phpmyadmin redis workspace` 启动容器；
	 * 进入 `Laradock/nginx/sites` 目录下新建 `larabbs.conf` 文件，写入以下代码：
	 
	   ```
	   server {
			listen 80;

			server_name larabbs.test;
			root /var/www/PHP/Code/larabbs/public;
			index index.php index.html index.htm;

			location / {
				 try_files $uri $uri/ /index.php$is_args$args;
			}

			location ~ \.php$ {
				try_files $uri /index.php =404;
				fastcgi_pass php-upstream;
				fastcgi_index index.php;
				fastcgi_buffers 16 16k;
				fastcgi_buffer_size 32k;
				fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
				#fixes timeouts
				fastcgi_read_timeout 600;
				include fastcgi_params;
			}

			location ~ /\.ht {
				deny all;
			}

			location /.well-known/acme-challenge/ {
				root /var/www/letsencrypt/;
				log_not_found off;
			}
	}

	   ``` 
	 * 重启 `nginx` 容器：`docker-compose restart nginx`;

3. 安装扩展包依赖：`composer install`
4. 生成配置文件
	 * 首先执行：`cp .env.example .env`；
	 * 找到 `API_PREFIX`，将其值设置为 `api`；
	 * 修改数据库信息；
	 * 使用 `Laradock` 的注意事项：
		 * `DB_HOST` 请填写为 `mysql`；
		 * 数据库需要自己创建
5. 生成密钥：`php artisan key:generate`；
6. 执行迁移：`php artisan migrate`；
7. 执行填充：`php artisan db:seed`；
8. 配置 `hosts` 文件：`172.17.0.1    larabbs.test`

## 前端工具集安装
> 代码里自带编译后的前端代码，如果你不想开发前端样式的话，你是不需要配置前端工具集的，可直接跳过。

* 安装 `node.js`；
* 安装 `Laravel Elixir`：`npm install`；
* 编译前端内容：`npm run dev`；
* 监控修改并自动编译：`npm run watch-poll`；

## 登录用户
> 只有 Id 为 1 和 2 的用户有后台权限

* `bar@example.com` 
* `password`

## Author

👤 **Hug.m**

* Twitter: [@Twitter](https://twitter.com/Twitter)
* Github: [@striveu](https://github.com/striveu)

## 🤝 Contributing

Contributions, issues and feature requests are welcome!<br />Feel free to check [issues page](https://github.com/striveu/larabbs/issues).

## Show your support

Give a ⭐️ if this project helped you!

<a href="https://www.patreon.com/Patreon">
<img src="https://cdn.learnku.com/uploads/images/201912/16/25461/sXfCIoQM0E.png!large" width="160">
</a>

## 📝 License

Copyright © 2019 [Hug.m](https://github.com/striveu).<br />
This project is [License](License Url) licensed.

***
_This README was generated with ❤️ by [readme-md-generator](https://github.com/kefranabg/readme-md-generator)_
