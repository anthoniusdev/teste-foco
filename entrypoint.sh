#!/bin/bash

until mysqladmin ping -h db --silent; do
  echo "Aguardando o MySQL estar disponível..."
  sleep 1
done

php artisan key:generate
php artisan migrate 
php artisan app:recover_data_xml
php artisan app:insert_coupon

exec "$@"