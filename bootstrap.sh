#!/usr/bin/env bash

# Use single quotes instead of double quotes to make it work with special-character passwords
PASSWORD='12345678'
PROJECTFOLDER='liganet'

# create project folder
sudo mkdir "/var/www/html/${PROJECTFOLDER}"

# update / upgrade
sudo apt-get update
sudo apt-get -y upgrade

# install apache 2.5 and php 5.5
sudo apt-get install -y apache2
sudo apt-get install -y php5

# install mysql and give password to installer
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password $PASSWORD"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $PASSWORD"
sudo apt-get -y install mysql-server
sudo apt-get install php5-mysql

# install phpmyadmin and give password(s) to installer
# for simplicity I'm using the same password for mysql and phpmyadmin
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2"
sudo apt-get -y install phpmyadmin

###################################################
sudo apt-get install -y htop
# install our cool stuff
sudo apt-get install -y libfontbox-java
sudo apt-get install -y libjempbox-java
sudo apt-get install -y libpdfbox-java
sudo apt-get install -y imagemagick
sudo apt-get install -y fop
#sudo apt-get install -y libxsl
wget https://dist.apache.org/repos/dist/dev/xmlgraphics/binaries/fop-pdf-images-2.1.0.SNAPSHOT-bin.zip
unzip fop-pdf-images-2.1.0.SNAPSHOT-bin.zip
unlink fop-pdf-images-2.1.0.SNAPSHOT-bin.zip
sudo mv fop-pdf-images-2.1.0.SNAPSHOT /home/ubuntu/fop-pdf-images
ln -s /home/ubuntu/fop-pdf-images/fop-pdf-images-2.1.0.SNAPSHOT.jar /home/ubuntu/fop-pdf-images/fop-pdf-images.jar

sudo cp -rp /vagrant/docs/fop /home/ubuntu/fop
sudo chmod 777 /home/ubuntu/fop
#php extensions
sudo apt-get install -y php5-xsl
sudo apt-get install -y php5-intl
sudo apt-get install -y php5-curl
sudo apt-get install -y php5-imagick
###################################################

# setup hosts file
VHOST=$(cat <<EOF
<VirtualHost *:80>
    DocumentRoot "/var/www/html/${PROJECTFOLDER}"
    <Directory "/var/www/html/${PROJECTFOLDER}">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF
)
echo "${VHOST}" > /etc/apache2/sites-available/000-default.conf

# enable mod_rewrite
sudo a2enmod rewrite

# restart apache
service apache2 restart

# install git
sudo apt-get -y install git

# install Composer
curl -s https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
