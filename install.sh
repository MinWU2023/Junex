#!/bin/bash
if [ ! -f ".env" ];then
  cp .env.example .env
fi
read -p "请输入网站地址 (http://baidu.com): " TheUrl
read -p "请输入数据库名称: " TheDatabase
read -p "请输入数据库用户名: " TheUser
read -p "请输入数据库密码: " ThePassword

sed -i 's#{URL}#'''$TheUrl'''#g' .env
sed -i "s/{MYSQL_DATABASE}/${TheDatabase}/g" .env
sed -i "s/{MYSQL_USERNAME}/${TheUser}/g" .env
sed -i "s/{MYSQL_PASSWORD}/${ThePassword}/g" .env
cp stub/controllers/NewsController.stub app/Http/Controllers/NewsController.php
cp stub/controllers/HomeController.stub app/Http/Controllers/HomeController.php
cp stub/controllers/PageController.stub app/Http/Controllers/PageController.php
cp stub/controllers/ProductController.stub app/Http/Controllers/ProductController.php
cp stub/controllers/DownloadController.stub app/Http/Controllers/DownloadController.php
cp stub/controllers/SitemapController.stub app/Http/Controllers/SitemapController.php
cp -r stub/views/*  resources/views/front/
cp stub/webpack.mix.js ./
cp stub/config/multilingual.stub config/multilingual.php
cp stub/routes/front.php routes/
composer install && npm install
chmod -R 777 addons storage public
if [ ! -d "public/addons" ];then
  mkdir public/addons && chmod -R 777 public/addons
fi
if [ ! -d "storage/app/addons" ];then
  mkdir storage/app/addons && chmod -R 777 storage/app/addons
fi
php artisan install
npm run prod
touch storage/robots.txt
wget http://diaodu.dyyweb.com/GeoLite2-City.mmdb.gz
gzip -d GeoLite2-City.mmdb.gz && mv GeoLite2-City.mmdb storage/
