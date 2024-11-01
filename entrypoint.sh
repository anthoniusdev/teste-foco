#!/bin/bash

# Aguarda o banco de dados estar disponível
until mysqladmin ping -h db --silent; do
  echo "Aguardando o MySQL estar disponível..."
  sleep 1
done

# Comandos adicionais do laravel
php artisan migrate 
php artisan app:recover_data_xml

# Executa o comando padrão
exec "$@"

