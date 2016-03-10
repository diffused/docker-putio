#!/bin/bash

PASSWORD_FILE=/tmp/.rsync
echo $RSYNC_PASSWORD > $PASSWORD_FILE
chmod 400 $PASSWORD_FILE

php Putio.php
rsync -rzvP --size-only --password-file=$PASSWORD_FILE /root/download/ $RSYNC_USER@$RSYNC_SERVER::$RSYNC_REPO/

