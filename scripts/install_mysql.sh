sudo apt update
sudo apt install mysql-server -y
sed -i 's/XKBLAYOUT="us"/XKBLAYOUT="ch"/g'/etc/default/keyboard
sudo systemctl start mysql.service

# Creazione dell'utente db_connector in MySQL
sudo mysql -u root <<-EOF
CREATE USER 'db_connector'@'localhost' IDENTIFIED BY 'Password&1';
GRANT ALL PRIVILEGES ON *.* TO 'db_connector'@'localhost';
FLUSH PRIVILEGES;
EOF
