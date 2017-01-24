#!/bin/bash

[ ! "$DEBUG" ] || return
if [ ! "$PUTIO_KEY" ]; then
	echo "Environment variable PUTIO_KEY missing"
	exit 0
fi

php Putio.php

if [ "$RSYNC_SERVER" ]; then
	PASSWORD_FILE=/tmp/.rsync
	echo $RSYNC_PASSWORD > $PASSWORD_FILE
	chmod 400 $PASSWORD_FILE
	rsync -rzvP --size-only --password-file=$PASSWORD_FILE /root/download/ $RSYNC_USER@$RSYNC_SERVER::$RSYNC_REPO/
fi
