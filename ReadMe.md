# Shopware demo env

## Run a local shopware env with gally

- Clone this repository
- Add gally plugin 
  ```shell
  git clone git@github.com:Elastic-Suite/gally-shopware-connector.git plugins/GallyPlugin
  ```
- Add Luma demo catalog plugin
  ```shell
  git clone git@github.com:Elastic-Suite/shopware-lumage-sample-data-plugin.git plugins/LumaSampleData
  ``` 
- Start shopware
  ```shell
  docker compose up -d # without traefik
  #docker compose -f compose.yml up -d # with `traefik`
  ```
- Install plugins
  ```shell
  docker compose exec shopware composer config minimum-stability dev
  # Refresh plugin list from source
  docker compose exec shopware bin/console plugin:refresh 
  # Install magento sample data
  docker compose exec shopware bin/console plugin:install MagentoLumaSampleDataPlugin
  docker compose exec shopware bin/console plugin:activate MagentoLumaSampleDataPlugin
  # Install Gally plugin
  docker compose exec shopware bin/console plugin:install GallyPlugin
  docker compose exec shopware bin/console plugin:activate GallyPlugin
  # Clear cache
  docker compose exec shopware bin/console cache:clear
  ```
- Install static analysis tools:
  ```shell
  docker compose exec shopware composer require --dev friendsofphp/php-cs-fixer phpstan/phpstan
  ```
- You shopware backoffice should be accessible from http://localhost:8082/admin (or http://shopware.docker.localhost/admin with traefik)
  - Login with `admin` / `shopware`
  - Configure you store frontend from **Sales channels > Storefront**
    - Entry point main navigation : Choose *Luma category tree*
    - Edit domain to `localhost:8082` (or `shopware.localhost` with traefik)
  - Configure gally plugin from **Extensions > My extensions > GallyPlugin > Configure** : enter your local gally instance url and credentials, there is the default value:
    - Url: `https://gally.local/api`
    - Email: `admin@example.com`
    - Passwor

  - Run static analyse tools :
    ```shell
    docker compose exec shopware vendor/bin/php-cs-fixer fix --dry-run --diff custom/plugins/GallyPlugin/
    docker compose exec shopware vendor/bin/phpstan --memory-limit=1G analyse -c custom/plugins/GallyPlugin/phpstan.neon
    ```
