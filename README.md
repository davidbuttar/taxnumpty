taxnumpty
=========

Web app I've developed to learn yeoman, currently has a working UK tax 
calculator but in future, hope to add more countries as well as relevant 
analysis and maybe even cross country comparisons.

http://taxedplanet.com

## Installing on a Virtual Machine
Run a virtual machine

    vagrant up

Add a host entry in `/etc/hosts`

    192.168.55.10 test-taxedplanet.taxedplanet.com

Point your browser to `http://test-taxedplanet.taxedplanet.com`

## Installing on your Host Machine
Install some linux (Debian) packages

    apt-get install apache2 php5 npm

Goto the directory where you have checked out the app and run the following commands.

    sudo npm install bower -g
    npm install
    bower install

Enable required apache modules

    sudo a2enmod rewrite
    sudo a2enmod header
    sudo a2enmod expires

Copy the `taxedplant.conf` to apache directory

    sudo cp <projectdir>cookbooks/taxedplanet/files/default/taxedplanet.conf
    /etc/apache2/sites-available/.
    sudo ln -snf /etc/apache2/sites-available/taxedplanet.conf
    /etc/apache2/sites-enabled/taxedplanet.conf

Start the apache webservice

    sudo service apache2 restart

# Production Build and Testing

Run the tests

    grunt test

To generate a production build of the app run

    grunt
