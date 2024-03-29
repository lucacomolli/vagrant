# -*- mode: ruby -*-
# vi: set ft=ruby :
# user: vagrant pass:vagrant

Vagrant.configure("2") do |config|

  PROXY_URL = "http://10.20.5.51:8888"
  PROXY_ENABLE = true
  BOX_IMAGE = "ubuntu/jammy64"
  BASE_INT_NETWORK = "10.10.20"
  BASE_HOST_ONLY_NETWORK = "192.168.56"

  config.vm.synced_folder "./site", "/var/www/html"

  # WEB
  config.vm.define "web.m340" do |web|
    web.vm.box = BOX_IMAGE
    web.vm.provider "virtualbox" do |vb|
      vb.gui = true
      vb.memory = "1024"
      vb.name = "web.m340"
    end
    web.vm.provision "shell", path: "scripts/install_apache.sh"
    if PROXY_ENABLE && Vagrant.has_plugin?("vagrant-proxyconf")
      web.proxy.http = PROXY_URL
      web.proxy.https = PROXY_URL
      web.proxy.no_proxy = "localhost,127.0.0.1"
    end
    web.vm.network "private_network", ip: "#{BASE_INT_NETWORK}.10", virtualbox__intnet: true
    web.vm.network "private_network", ip: "#{BASE_HOST_ONLY_NETWORK}.10"
  end
  
  # DB
  config.vm.define "db.m340" do |db|
    db.vm.box = BOX_IMAGE
    db.vm.provider "virtualbox" do |vb|
      vb.gui = true
      vb.memory = "1024"
      vb.name = "db.m340"
    end
    db.vm.provision "shell", path: "scripts/install_mysql.sh"
    if PROXY_ENABLE && Vagrant.has_plugin?("vagrant-proxyconf")
      db.proxy.http = PROXY_URL
      db.proxy.https = PROXY_URL
      db.proxy.no_proxy = "localhost,127.0.0.1"
    end
    db.vm.synced_folder "./site/application/config", "/home/vagrant/sql/"
    db.vm.network "private_network", ip: "#{BASE_INT_NETWORK}.11", virtualbox__intnet: true
  end

end
