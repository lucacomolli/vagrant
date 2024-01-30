#!/bin/bash

# Aggiornamento dei pacchetti
sudo apt update

# Installazione di MySQL Server
sudo apt install mysql-server -y

# Modifica della disposizione della tastiera
sed -i 's/XKBLAYOUT="us"/XKBLAYOUT="ch"/g' /etc/default/keyboard

# Avvio del servizio MySQL
sudo systemctl start mysql.service

sudo mysql -u root <<-EOF
DROP USER IF EXISTS 'db_connector'@'%';
CREATE USER 'db_connector'@'%' IDENTIFIED BY 'Password&1';
GRANT ALL PRIVILEGES ON *.* TO 'db_connector'@'%';
FLUSH PRIVILEGES;
EOF
# Creazione dell'utente db_connector in MySQL
sudo mysql < /home/vagrant/sql/db.sql

# Modifica dell'indirizzo di bind e della porta di ascolto di MySQL
sudo tee -a /etc/mysql/mysql.conf.d/mysqld.cnf <<EOF
  [mysqld]
  bind-address = 10.10.20.11
EOF

# Riavvio del servizio MySQL
sudo systemctl restart mysql.service
