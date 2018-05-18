#!/bin/bash
rm -rf var/cache/* && php70 bin/console assets:install && php70 bin/console assetic:dump && php70 bin/console d:s:u --dump-sql && php70 bin/console d:s:u --force