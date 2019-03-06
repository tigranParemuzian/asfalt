#!/bin/bash
rm -rf var/cache/* &&
rm -rf var/logs/* && 
mkdir -p web/uploads && 
mkdir -p web/uploads/files && 
HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1` && 
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs var/sessions web/uploads web/uploads/files && 
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs var/sessions web/uploads web/uploads/files
