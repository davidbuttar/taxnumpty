##
# This file loads the correct packages and sets up the files
# as required

# Install the packages required
package "git"
package "apache2"
package "php5"
package "php5"
package "npm"
package "vim"

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

# Restart the services
%w{apache2}.each do |service_mod|
    service "#{service_mod}" do
        action [ :enable, :restart ]
    end
end
