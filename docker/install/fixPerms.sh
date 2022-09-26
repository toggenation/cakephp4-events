#!/bin/bash

# fixes perms after running tests and they are owned by root

BASE="${1:-/var/www/wms}"

if [ ! -d "$BASE" ]
then
    echo "Base path \"${BASE}\" doesn't exist please specify a path";
    exit
fi

mkdir -p ${BASE}/webroot/files/daily_reports

chmod 777 ${BASE}/logs ${BASE}/tmp -Rv

chown www-data:www-data ${BASE}/webroot/files -Rv

chown www-data:www-data ${BASE}/logs ${BASE}/tmp -Rv

chmod 777 ${BASE}/webroot/files -Rv

find ${BASE}/tmp -type f -delete

