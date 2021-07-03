# Prerequisite
- PHP 7.1
- Apache 2.4
- MySQL 7

# Configure local
1. open your apache server and add this block to httpd.vhosts.conf
```
<VirtualHost *:80>
  ServerName ehpad.home
  ServerAlias ehpad.home
  DocumentRoot "${INSTALL_DIR}/www/ehpad/app/"
  <Directory "${INSTALL_DIR}/www/ehpad/app/">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require local
  </Directory>
</VirtualHost>
```

2. update your hosts file in windows : c:\Windows\System32\Drivers\etc\hosts and add this block
```
127.0.0.1 ehpad.home
```



# Run on local
1.
```bash
composer install
```
2.
```bash
composer dump-autoload
```

3. Update database credentials
- open /sites/default/setting.php and change database infos
- Info : do not forget to create your database in local






