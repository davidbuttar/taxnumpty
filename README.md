taxnumpty
=========

Web app I've developed to learn yeoman, currently has a working UK tax calculator but in future, hope to add more countries as well as relvant analysis and maybe even cross country comparisons.

http://taxedplanet.com

Installation
=============

Taxedplanet requires bower and apache, to install and run.

Goto the directory where you have checked out the app and run the following commands.

    npm install
    bowser install

Then you should create an apache virtual host and has the app directory as it's document root. Apache will also need to support .htaccess files.

To get a production build of the app run

    grunt
