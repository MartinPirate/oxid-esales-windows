FROM httpd:2.4

# Install necessary packages
RUN apt-get update && apt-get install -y \
    libapache2-mod-fcgid \
    && rm -rf /var/lib/apt/lists/*

# Enable required Apache modules
RUN sed -i \
    -e 's/^#\(LoadModule proxy_module\)/\1/' \
    -e 's/^#\(LoadModule proxy_fcgi_module\)/\1/' \
    -e 's/^#\(LoadModule rewrite_module\)/\1/' \
    -e 's/^#\(LoadModule ssl_module\)/\1/' \
    /usr/local/apache2/conf/httpd.conf

# Include extra config
RUN echo "Include conf/extra/oxid.conf" >> /usr/local/apache2/conf/httpd.conf

# Copy custom Apache config
COPY oxid.conf /usr/local/apache2/conf/extra/oxid.conf

WORKDIR /var/www/html
