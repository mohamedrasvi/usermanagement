# usermanagement

Installation instruction 
=============================
1. clon the repo
2. change the name .env.example to .env
3. change the database name , db user name and db password on .env file
4. terminal run this command php artisan migrate
5. download all dependencies, libraries type on terminal (composer update) make sure you already have composer on your computer.



setup on your local host(repo) , I normally  do on my linux  pc, lap, setup virtual host like example testing.user.com and point the DocumentRoot	/var/www/html/users/public this one you can do way you want to run the repo on your computer  

make sure storage folder writable if not you can make it writable by typing on terminal (chmod -R 777  storage/)

make sure your rest api client postman whatever to setup header properly 
example (Content-Type: application/json, X-Requested-With :XMLHttpRequest) otherwise validation error message redirect to page rather it shows error message via json on api

sample api example get method : http://testing.user.com/api/user ,
http://testing.user.com/api/user/1

post method http://testing.user.com/api/register

like that you can see routes setting  on routes/api.php

u can find db sql file on root directory (user.sql)





