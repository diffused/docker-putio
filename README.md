# docker-putio

[![Docker Hub repository](http://dockeri.co/image/nouchka/putio)](https://registry.hub.docker.com/u/nouchka/putio/)

[![](https://images.microbadger.com/badges/image/nouchka/putio.svg)](https://microbadger.com/images/nouchka/putio "Get your own image badge on microbadger.com")
[![](https://images.microbadger.com/badges/version/nouchka/putio.svg)](https://microbadger.com/images/nouchka/putio "Get your own version badge on microbadger.com")
[![Docker Automated buil](https://img.shields.io/docker/automated/nouchka/putio.svg)](https://hub.docker.com/r/nouchka/putio/)
[![Build Status](https://travis-ci.org/nouchka/docker-putio.svg?branch=master)](https://travis-ci.org/nouchka/docker-putio)
<!---
[![Docker Stars](https://img.shields.io/docker/stars/nouchka/docker-putio.svg)](https://hub.docker.com/r/nouchka/putio/)
[![Docker Pulls](https://img.shields.io/docker/pulls/nouchka/docker-putio.svg)]()
--->

# Versions

Version follows putio api version

* 2.0 (latest) (based on 2.0 branch)

# Image

This image is a debian jessie image with php cli support. Library uses for putio is https://github.com/nicoSWD/put.io-api-v2
The script download all files from putio with the same directories. If there is no files on putio it removes everything in the directory. Then if a rsync server has been configured, it will sync the directory.
If you don't use rsync, just mount /root/download/ directory.

# Use

Use from command line:

	docker run -e 'PUTIO_KEY=ACCESS_TOKEN' nouchka/putio
or use with docker compose:

	docker-compose up -d
Environment variables:

	PUTIO_KEY=ACCESS_TOKEN
	RSYNC_REPO=putio
	RSYNC_SERVER=rsyncd.server.lan
	RSYNC_USER=rsync-user
	RSYNC_PASSWORD=rsync-password

# Todo

* CI (difficult without a test account on putio)
* Migrate docker-compose file format to version 2/3

# Donate

Bitcoin Address: 15NVMBpZJTvkefwfsMAFA3YhyiJ5D2zd3R
