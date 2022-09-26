#!/bin/bash

VERSION=v16.14.0
DISTRO='linux-x64'

mkdir /build
cd /build && \
    wget https://nodejs.org/dist/v16.14.0/node-${VERSION}-${DISTRO}.tar.xz && \
    tar -xvf node-${VERSION}-${DISTRO}.tar.xz --strip-components=1 -C /usr/local
