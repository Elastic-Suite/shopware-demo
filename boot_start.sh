# Change our user to something else than UID 33.

# Extract UID and GID
TARGET_UID=$(echo ${DOCKER_USER:-33:33} | cut -d: -f1)
TARGET_GID=$(echo ${DOCKER_USER:-33:33} | cut -d: -f2)

# Modify www-data user and group
sudo usermod -u $TARGET_UID dockware
sudo groupmod -g $TARGET_GID www-data

# Create required directories
sudo mkdir -p /var/www/html/public/media /var/www/html/public/thumbnail

# Fix ownership of existing files
sudo chown -R dockware:www-data /var/www/html /var/www/.npm
sudo chmod g+w -R /var/www/html/var /var/www/html/public/media /var/www/html/public/thumbnail /var/www/.npm
