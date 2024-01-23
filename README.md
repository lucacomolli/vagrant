# Vagrant file for two different VMs

---

## Luca Comolli I4BC

### This vagrantfile is used to launch two VMs and use one for the Website and one for the Database

The **web** VM uses the **ubuntu/jammy64** distro, is launched with **VM virtualbox**, has a script to install apache and php, and set the keyboard to CH layout and, with the use of a variable and by checking if the **vagrant-proxyconf** plugin is there, uses a proxy connection to access internet.
To access the website via the main pc (the one running virtualbox) a **host_only** network inteface has ben configured.

```ruby
config.vm.define "web.m340" do |web|
    web.vm.box = BOX_IMAGE # ubuntu/jammy64
    web.vm.provider "virtualbox" do |vb|
      vb.gui = true
      vb.memory = "1024"
    end
    # NAT for proxy
    web.vm.network "private_network", ip: "#{BASE_INT_NETWORK}.10"
    # Host-Only
    web.vm.network "private_network", ip: "#{BASE_HOST_ONLY_NETWORK}.10", virtualbox__intnet: true
    # Installing apache and setting CH layout
    web.vm.provision "shell", path: "scripts/install_apache.sh"
    # Checking Variable and plugin
    if PROXY_ENABLE && Vagrant.has_plugin?("vagrant-proxyconf")
      web.proxy.http = PROXY_URL
      web.proxy.https = PROXY_URL
      web.proxy.no_proxy = "localhost,127.0.0.1"
    end
  end
```

`install_apache.sh` script:

```shell
sudo apt update
sudo apt install apache2 -y
sed -i 's/XKBLAYOUT="us"/XKBLAYOUT="ch"/g'/etc/default/keyboard
sudo apt install php -y
```

As for the **db** VM it is very similar to the web VM the main differences are the **script**, and the network interfaces.

```ruby
config.vm.define "db.m340" do |db|
    db.vm.box = BOX_IMAGE
    db.vm.provider "virtualbox" do |vb|
      vb.gui = true
      vb.memory = "1024"
    end
    db.vm.network "private_network", ip: "#{BASE_INT_NETWORK}.11"
    db.vm.provision "shell", path: "scripts/install_mysql.sh"
    if PROXY_ENABLE && Vagrant.has_plugin?("vagrant-proxyconf")
      db.proxy.http = PROXY_URL
      db.proxy.https = PROXY_URL
      db.proxy.no_proxy = "localhost,127.0.0.1"
    end
  end
```

`install_mysql.sh` script:

```shell
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
```

This script not only installs mysql but creates a **db_connector** to use for the website and db connection in php.
