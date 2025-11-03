# Shopware demo env

## Run a local shopware env with gally

- Clone this repository
- Add Gally and Luma demo catalog plugins 
  ```shell
  git clone git@github.com:Elastic-Suite/gally-shopware-connector.git plugins/GallyPlugin
  git clone git@github.com:Elastic-Suite/shopware-lumage-sample-data-plugin.git plugins/LumaSampleData
  ```
- Fix permission
  ```
  sudo chown -R www-data:www-data src plugins
  ```
- Set env vars:

  | Var                 | Description                           | Example value                    |
  |---------------------|---------------------------------------|----------------------------------|
  | `SERVER_NAME`       | The shopware domain you want to use   | **shopware.connector.localhost** |
  | `GALLY_SERVER_NAME` | The server name you defined for gally | **gally.connector.local**        |
  | `DOCKER_USER`       | Your user id and group id             | **1000:1000**                   |

- Start shopware
  ```shell
  docker compose up -d
  # For lts version:
  docker compose -f compose.yml -f compose.lts.yml -f compose.override.yml up -d
  ```
- Install plugins
  ```shell
  # Update compose minimum stability in order to be able to require not released sdk package.
  docker compose exec shopware composer config minimum-stability dev
  # Composer install
  docker compose exec shopware composer install
  # Refresh plugin list from source
  docker compose exec shopware bin/console plugin:refresh 
  # Install magento sample data (it can take several minutes)
  docker compose exec shopware bin/console plugin:install MagentoLumaSampleDataPlugin -a
  # Install Gally plugin
  docker compose exec shopware bin/console plugin:install GallyPlugin -a
  # Clear cache
  docker compose exec shopware bin/console cache:clear:all
  ```
- Install static analysis tools:
  ```shell
  docker compose exec shopware composer require --dev friendsofphp/php-cs-fixer:3.65 phpstan/phpstan
  ```
- You shopware backoffice should be accessible from https://shopware.connector.localhost/admin (or the `SERVER_NAME` you defined)
  - Login with `admin` / `shopware`
  - Configure you store frontend from **Sales channels > Storefront**
    - Entry point main navigation : Choose *Luma category tree*
    - Edit domain to `http://shopware.connector.localhost` (or the `SERVER_NAME` you defined), http, not https !
  - Configure gally plugin from **Extensions > My extensions > GallyPlugin > Configure** : enter your local gally instance url and credentials, there is the default value:
    - Url: `https://gally.connector.local/api` (or the `GALLY_SERVER_NAME` you defined)
    - Email: your gally admin user email
    - Password: your gally admin user password
  
- Then you can sync you shopware catalog with gally and index you data:
  ```shell
  docker compose exec shopware bin/console gally:structure:sync
  docker compose exec shopware bin/console gally:index  
  ```

- If you need to rebuild js/css files, you can run these commands
  ```shell
  docker compose exec shopware bin/build-administration.sh # For admin, or watch-administration.sh if you need to build in real time with your change
  docker compose exec shopware bin/build-storefront.sh     # For front, or watch-storefront.sh if you need to build in real time with your change
  ```

- Run static analyse tools :
  ```shell
  docker compose exec shopware vendor/bin/php-cs-fixer fix --dry-run --diff custom/plugins/GallyPlugin/
  docker compose exec shopware vendor/bin/phpstan --memory-limit=1G analyse -c custom/plugins/GallyPlugin/phpstan.neon
  ```
