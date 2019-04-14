FROM phpmyadmin/phpmyadmin:4.7

COPY mapper /etc/phpmyadmin/mapper
COPY config.user.inc.php /etc/phpmyadmin/config.user.inc.php

RUN cd /etc/phpmyadmin/mapper \
	&& php composer.phar install
