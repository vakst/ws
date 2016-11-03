Description
----------------------------------
Example PHP WebSocket server and PHP WebSocket client

Based on socketo.me

Install
----------------------------------

1) If you don't have Composer yet, just run the following command:

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer 
```

2) Checkout project from GitHub

```bash
cd <path-to-install>
git init
git remote add origin https://github.com/vakst/ws.git
git pull origin master
```

3) Use the "composer install" command to install dependencies

```bash
composer install
```
4) Launch web-server

```bash
php -S 0.0.0.0:80 -t www
```

4) Launch ws-server

```bash
php bin/messenger-server.php
```

Commands
----------------------------------
```bash
php bin/messenger-client.php get-all-users

php bin/messenger-client.php get-all-user-task=USERID

php bin/messenger-client.php send-message=MESSAGEID task=TASKID message=MESSAGE

php bin/messenger-client.php send-message=MESSAGEID message=MESSAGE

php bin/messenger-client.php send-message=all message=MESSAGE
```