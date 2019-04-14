FROM phpmyadmin/phpmyadmin:4.7

COPY mapper /etc/phpmyadmin/mapper
COPY config.user.inc.php /etc/phpmyadmin/config.user.inc.php
COPY check_environment_cfg.php /etc/phpmyadmin/check_environment_cfg.php

RUN cd /etc/phpmyadmin/mapper \
	&& php composer.phar install
