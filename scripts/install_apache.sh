#!/bin/bash

# Aggiornamento dei pacchetti
sudo apt update

# Installazione di Apache2
sudo apt install apache2 -y

# Modifica della disposizione della tastiera
sed -i 's/XKBLAYOUT="us"/XKBLAYOUT="ch"/g' /etc/default/keyboard

# Installazione di PHP
sudo apt install php -y

# Installazione dei pacchetti mysqli e mbstring
sudo apt install php-mysqli php-mbstring -y

# Abilitazione degli errori in PHP
sudo sed -i 's/display_errors = Off/display_errors = On/g' /etc/php/8.1/apache2/php.ini
sudo sed -i 's/display_startup_errors = Off/display_startup_errors = On/g' /etc/php/8.1/apache2/php.ini

# Abilitazione dei pacchetti mysqli e mbstring
sudo phpenmod mysqli mbstring

# Configurazione di Apache per permettere l'override del file .htaccess
sudo sh -c 'echo "<Directory /var/www/html>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride All
    Require all granted
</Directory>" >> /etc/apache2/sites-available/000-default.conf'

# Abilitazione del modulo rewrite di Apache
sudo a2enmod rewrite

# Riavvio del server Apache
sudo systemctl restart apache2
