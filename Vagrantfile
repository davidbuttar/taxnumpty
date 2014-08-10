# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    config.vm.box = "ffuenf/ubuntu-14.04-server-amd64"
    config.vm.hostname = "test-taxedpanet.taxplanet.com"
    config.vm.post_up_message = "try http://test-taxedplanet.taxedplanet.com in your browser"

    config.vm.network "forwarded_port", guest: 80, host: 8080
    config.vm.network "private_network", ip: "192.168.55.10"

    # Enable if you want this device to appear as a physical device on the network
    # config.vm.network "public_network"

    config.vm.synced_folder ".", "/vagrant_data"

    config.vm.provider "virtualbox" do |vb|
        # Use VBoxManage to customize the VM. For example to change memory:
        vb.customize ["modifyvm", :id, "--memory", "1024"]
    end
  
    # Enable provisioning with chef solo, specifying a cookbooks path, roles
    # path, and data_bags path (all relative to this Vagrantfile), and adding
    # some recipes and/or roles.
    #
    config.vm.provision "chef_solo" do |chef|
        chef.custom_config_path = "cookbooks/default.conf"
        chef.add_recipe "taxedplanet"
    end
end
