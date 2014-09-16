#!/usr/bin/env bash

whoami

sudo apt-get update

# install git
sudo apt-get -y install git

# install nginx
sudo apt-get -y install apache

# install php5
sudo apt-get -y install php5 php5-curl php5-cli

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
sudo apt-get -y install mysql-server

#sudo mysqladmin -u root root secretroot

sudo apt-get install -y mysql-client php5-mysql

# configuring apache
sudo /etc/init.d/apache2 stop
sudo chown -R vagrant:vagrant /var/log/apache2
sudo chown -R vagrant:vagrant /var/lock/apache2

# setup apache site

if [ -f /vagrant/.htaccess ]; then
    sudo rm -rf /vagrant/.htaccess
fi

sudo cat <<EOT >/vagrant/.htaccess
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
EOT

# enable site gcda
if [ -f /etc/apache2/sites-enabled/000-default.conf ]; then
    sudo rm -rf /etc/apache2/sites-available/000-default.conf
fi

if [ -f /etc/apache2/sites-available/blog.conf ]; then
    sudo rm -rf /etc/apache2/sites-available/blog.conf
fi

sudo cat <<EOT >/vagrant/blog_conf
<VirtualHost *:80>
        ServerAdmin webmaster@localhost

        DocumentRoot /vagrant
        DirectoryIndex index.php

        ServerName wp.blog.local


        <Directory /vagrant/>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order deny,allow
                allow from all
                Satisfy Any

                <IfModule mod_rewrite.c>
                    RewriteEngine On
                    RewriteBase /
                    RewriteRule ^index\.php$ - [L]
                    RewriteCond %{REQUEST_FILENAME} !-f
                    RewriteCond %{REQUEST_FILENAME} !-d
                    RewriteRule . /index.php [L]
                </IfModule>
        </Directory>

        ErrorLog /var/log/apache2/monsite_error.log

        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        #LogLevel warn
        LogLevel debug

        CustomLog /var/log/apache2/monsite_access.log combined

</VirtualHost>
EOT

if [ ! -f /etc/apache2/envvars_bc ]; then
    cp /etc/apache2/envvars /etc/apache2/envvars_bc
fi

cat <<EOT >/etc/apache2/envvars

# envvars - default environment variables for apache2ctl

# this won't be correct after changing uid
unset HOME

# for supporting multiple apache2 instances
if [ "${APACHE_CONFDIR##/etc/apache2-}" != "${APACHE_CONFDIR}" ] ; then
        SUFFIX="-${APACHE_CONFDIR##/etc/apache2-}"
else
        SUFFIX=
fi

# Since there is no sane way to get the parsed apache2 config in scripts, some
# settings are defined via environment variables and then used in apache2ctl,
# /etc/init.d/apache2, /etc/logrotate.d/apache2, etc.
export APACHE_RUN_USER=vagrant
export APACHE_RUN_GROUP=vagrant
export APACHE_PID_FILE=/var/run/apache2$SUFFIX.pid
export APACHE_RUN_DIR=/var/run/apache2$SUFFIX
export APACHE_LOCK_DIR=/var/lock/apache2$SUFFIX
# Only /var/log/apache2 is handled by /etc/logrotate.d/apache2.
export APACHE_LOG_DIR=/var/log/apache2$SUFFIX

## The locale used by some modules like mod_dav
export LANG=C
## Uncomment the following line to use the system default locale instead:
#. /etc/default/locale

export LANG

## The command to get the status for 'apache2ctl status'.
## Some packages providing 'www-browser' need '--dump' instead of '-dump'.
#export APACHE_LYNX='www-browser -dump'

## If you need a higher file descriptor limit, uncomment and adjust the
## following line (default is 8192):
#APACHE_ULIMIT_MAX_FILES='ulimit -n 65536'


## If you would like to pass arguments to the web server, add them below
## to the APACHE_ARGUMENTS environment.
#export APACHE_ARGUMENTS=''

EOT

sudo mv /vagrant/blog_conf /etc/apache2/sites-available/blog.conf
sudo a2ensite blog.conf
sudo a2dissite 000-default.conf
sudo a2enmod rewrite

sudo /etc/init.d/apache2 restart

# Configuring les acces au fichier de application pour user cli et web
sudo usermod -g vagrant vagrant

if [ `grep -c "umask 0002" /home/vagrant/.bashrc` -eq 0 ]
then
    echo "umask 0002" >>/home/vagrant/.bashrc
fi

