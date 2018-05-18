#!/bin/bash
rm -rf var/cache/ * && bin/console cache:clear && bin/console assets:install && bin/console assetic:dump && bin/console d:s:u --dump-sql && bin/console d:s:u --force