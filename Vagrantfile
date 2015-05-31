VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "trusty64"

  config.vm.provision "docker" do |d|
    d.run "tutum/wordpress", args: "-p '80:80'"
  end

  config.vm.network "forwarded_port", guest: 80, host: 8080

end
