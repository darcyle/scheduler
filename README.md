test
====

A Symfony project created on August 23, 2015, 3:48 am.


Example apache config:


<VirtualHost *:8888>
    ServerName scheduler.lan
    ServerAlias scheduler

    SetEnv          SYMFONY__DATABASE__USER username
    SetEnv          SYMFONY__DATABASE__PASS password
    SetEnv          SYMFONY__DATABASE__HOST localhost
    SetEnv          SYMFONY__DATABASE__PORT 8889
    SetEnv          SYMFONY__DATABASE__DRIVER pdo_mysql
    SetEnv          SYMFONY__DATABASE__name scheduler


    DocumentRoot /Applications/MAMP/htdocs/web
    <Directory /Applications/MAMP/htdocs/web>
        AllowOverride None
        Order Allow,Deny
        Allow from All

        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ app_dev.php [QSA,L]
        </IfModule>
    </Directory>

    # uncomment the following lines if you install assets as symlinks
    # or run into problems when compiling LESS/Sass/CoffeScript assets
    # <Directory /var/www/project>
    #     Options FollowSymlinks
    # </Directory>

    ErrorLog "/Applications/MAMP/logs/apache_error.log"
</VirtualHost>