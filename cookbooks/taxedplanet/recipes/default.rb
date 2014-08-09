##
# This file loads the correct packages and sets up the files
# as required

# Install the packages required
package "git"
package "apache2"
package "php5"
package "vim"
package "npm"

# Install the bower command globally
execute "npm install bower -g" do
    user 'root'
end

# Create the node link for bower to use
link "/usr/bin/node" do
    to "/usr/bin/nodejs"
end

# Configure the Apache server, 
#  - Add our configuration
#  - Enable our configuration
#  - Disable the default
cookbook_file 'taxedplanet.conf' do
    path '/etc/apache2/sites-available/taxedplanet.conf'
    mode '644'
    owner 'root'
    action [ :delete, :create ]
end
link "/etc/apache2/sites-enabled/taxedplanet.conf" do
    to "/etc/apache2/sites-available/taxedplanet.conf"
end
file '/etc/apache2/sites-enabled/000-default.conf' do
    action :delete
    manage_symlink_source true
end

# Enable apache headers
%w{rewrite headers expires}.each do |modules_mod|
    execute "a2enmod #{modules_mod}" do
        user 'root'
        action :run
    end
end

# Install the npm locally
execute "npm-install" do
    command 'npm install'
    cwd '/vagrant_data'
    user 'vagrant'
    notifies :run, 'execute[bower-install]', :immediately
end

# Install the bower locally
execute "bower-install" do
    command 'bower install -s --allow-root'
    cwd '/vagrant_data'
    user 'root'
    action :nothing
end

# Restart the services
%w{apache2}.each do |service_mod|
    service "#{service_mod}" do
        action [ :enable, :restart ]
    end
end
