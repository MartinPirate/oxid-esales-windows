#!/bin/bash
set -e

# Wait for MySQL to be ready
echo "Waiting for MySQL..."
while ! mysql -h"mysql" -u"oxid" -p"oxid" --skip-ssl -e "SELECT 1" &>/dev/null; do
    sleep 2
done
echo "MySQL is ready!"

# Install OXID if not already installed
if [ ! -f /var/www/html/source/composer.json ]; then
    echo "Installing OXID eShop..."
    cd /var/www/html

    # Clean directory first (remove hidden files too)
    rm -rf /var/www/html/* /var/www/html/.[!.]* 2>/dev/null || true

    composer create-project --no-interaction --no-dev oxid-esales/oxideshop-project . dev-b-7.3-ce
    echo "OXID eShop installed!"
fi

# Fix permissions for www-data
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html
echo "Permissions set."

exec "$@"
