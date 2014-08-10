name 'taxedplanet'
maintainer 'Shahmir Javaid'
maintainer_email 'shahmirj@gmail.com'
description 'Install/Configure Virtual machine'
version '1.0.0'

%w(debian ubuntu centos redhat smartos).each do |os|
  supports os
end

#suggests 'application_nodejs'
