#!/bin/bash

# Aggiornamento dei pacchetti
sudo apt update

# Installazione di MySQL Server
sudo apt install mysql-server -y

# Modifica della disposizione della tastiera
sed -i 's/XKBLAYOUT="us"/XKBLAYOUT="ch"/g' /etc/default/keyboard

# Avvio del servizio MySQL
sudo systemctl start mysql.service

# Creazione dell'utente db_connector in MySQL
sudo mysql -u root <<-EOF
DROP USER IF EXISTS 'db_connector'@'%';
CREATE USER 'db_connector'@'%' IDENTIFIED BY 'Password&1';
GRANT ALL PRIVILEGES ON *.* TO 'db_connector'@'%';
FLUSH PRIVILEGES;
CREATE DATABASE IF NOT EXISTS magazzino;
USE magazzino;
DROP TABLE IF EXISTS stock;
DELIMITER //
CREATE TABLE stock (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome_prodotto VARCHAR(255),
  quantità INT,
  prezzo DECIMAL(10,2)
)//
INSERT INTO stock (nome_prodotto, quantità, prezzo)
VALUES 
('Prodotto1', 10, 9.99),
('Prodotto2', 20, 19.99),
('Prodotto3', 30, 29.99),
('Prodotto4', 300, 299.99)//
DELIMITER ;
EOF

# Modifica dell'indirizzo di bind e della porta di ascolto di MySQL
sudo sed -i 's/bind-address = .*/bind-address = 10.10.20.11/g' /etc/mysql/mysql.conf.d/mysqld.cnf
sudo sed -i 's/port = .*/port = 3306/g' /etc/mysql/mysql.conf.d/mysqld.cnf

# Riavvio del servizio MySQL
sudo systemctl restart mysql.service
