FROM php:8.1-fpm

ENV PUPPETEER_EXECUTABLE_PATH="/usr/bin/chromium"

ARG NODE_VERSION=v18.8.0

RUN apt-get update && apt-get install --no-install-recommends -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    icu-devtools libicu-dev \
    chromium wget \
    cmake \
    bash-completion \
    # psmisc provides fuser
    psmisc \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install intl pdo pdo_mysql pdo_pgsql

RUN cd /usr/local/etc/php/conf.d/ && \
    echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/docker-php-ram-limit.ini

RUN mkdir /build && apArch=$(arch); \
    case "$apArch" in \
    x86_64) export DISTRO='linux-x64' ;; \
    aarch64) export DISTRO='linux-arm64' ;;\
    esac;\ 
    cd /build && \
    wget https://nodejs.org/dist/${NODE_VERSION}/node-${NODE_VERSION}-${DISTRO}.tar.xz && \
    tar -xvf node-${NODE_VERSION}-${DISTRO}.tar.xz --strip-components=1 -C /usr/local

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN cp /etc/apt/sources.list /etc/apt/sources.list~

RUN echo 'deb http://deb.debian.org/debian bullseye main contrib non-free' > /etc/apt/sources.list
RUN echo 'deb-src http://deb.debian.org/debian bullseye main contrib non-free' >> /etc/apt/sources.list
RUN echo 'deb http://deb.debian.org/debian-security/ bullseye-security main contrib non-free' >> /etc/apt/sources.list
RUN echo 'deb-src http://deb.debian.org/debian-security/ bullseye-security main contrib non-free' >> /etc/apt/sources.list
RUN echo 'deb http://deb.debian.org/debian bullseye-updates main contrib non-free' >> /etc/apt/sources.list
RUN echo 'deb-src http://deb.debian.org/debian bullseye-updates main contrib non-free' >> /etc/apt/sources.list

RUN apt-get update && \
    apt-get -y --no-install-recommends \
    build-dep glabels autoconf automake xz-utils cmake

COPY glabels/glabels-3.4.1.tar.xz /build/glabels-3.4.1.tar.xz
COPY glabels/zint-2.6.3_final.tar.gz /build/zint-2.6.3_final.tar.gz
COPY glabels/barcode-0.98.tar.gz /build/barcode-0.98.tar.gz

# zint barcode
RUN cd /build && \
    tar xzf zint-2.6.3_final.tar.gz && \
    cd zint-2.6.3.src/ && \
    mkdir build && cd build && \
    cmake .. && make && make install

# gnu barcode
RUN cd /build && \
    tar xzf barcode-0.98.tar.gz && \
    cd barcode-0.98/ && \
    ./configure && make && \
    make install

RUN cd /build && \
    tar xvf glabels-3.4.1.tar.xz

COPY glabels/glabels-externs.patch /build/

RUN cd /build && patch -s -p0 < glabels-externs.patch && \
    cd /build/glabels-3.4.1/ && \
    ./configure && \
    make && make install && ldconfig

RUN apt-get install -y cups-bsd cups-client cups-common openjdk-17-jdk-headless

# add path for bin/cake and vendor/bin
RUN echo 'PATH=/var/www/wms/vendor/bin:/var/www/wms/bin:$PATH' >> /root/.profile

# install fonts for PDF output
RUN echo "ttf-mscorefonts-installer msttcorefonts/accepted-mscorefonts-eula select true" | debconf-set-selections
RUN apt-get install -y --no-install-recommends fontconfig ttf-mscorefonts-installer
ADD fonts/localfonts.conf /etc/fonts/local.conf
RUN fc-cache -f -v

# Composer install
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN apt-get install -y aptitude

RUN aptitude markauto $(apt-cache showsrc glabels | sed -e '/Build-Depends/!d;s/Build-Depends: \|,\|([^)]*),*\|\[[^]]*\]//g')

RUN apt-get -y autoremove

RUN apt-get -y --no-install-recommends install libebook-1.2-20 barcode libqrencode4 libiec61883-0 libiec16022-0 git

RUN pecl install mailparse \
    && docker-php-ext-enable mailparse
# install dependencies 
RUN apt-get update && apt-get install --no-install-recommends -y \
    vim poppler-utils libtidy-dev \
    ssh \
    libssh2-1 \
    libssh2-1-dev \
    wget \
    yui-compressor libzip-dev \ 
    lsb-release jq \
    zip \
    libssl-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install ssh2 extension
RUN wget -O libssh2.tar.gz https://www.libssh2.org/download/libssh2-1.10.0.tar.gz \
    && wget -O ssh2.tgz https://pecl.php.net/get/ssh2-1.3.1.tgz \
    && mkdir libssh2 && tar vxzf libssh2.tar.gz -C libssh2 --strip-components 1 \
    && mkdir ssh2 && tar vxzf ssh2.tgz -C ssh2 --strip-components 1 \
    && cd libssh2 && ./configure \
    && make && make install \
    && cd ../ssh2 && phpize && ./configure --with-ssh2 \
    && make && make install \
    && echo "extension=ssh2.so" >> /usr/local/etc/php/conf.d/ssh2.ini \
    && cd ../ && rm -rf libssh2.tar.gz ssh2.tgz ssh2 libssh2

RUN docker-php-ext-install tidy && \
    docker-php-ext-enable tidy && \
    docker-php-ext-install exif && \
    docker-php-ext-install zip

RUN apt-get clean && apt-get autoremove -y && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/src

# bash aliases to provide migrate shortcuts
COPY bash_aliases /root/.bash_aliases

RUN echo 'source ~/.bash_aliases' >> /root/.bashrc

RUN rm -rf /build

