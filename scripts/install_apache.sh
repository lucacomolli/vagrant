sudo apt update
sudo apt install apache2 -y
sed -i 's/XKBLAYOUT="us"/XKBLAYOUT="ch"/g'/etc/default/keyboard
sudo apt install php -y