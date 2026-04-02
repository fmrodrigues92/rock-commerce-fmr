#!/bin/sh
set -e

php artisan key:generate

echo "Aguardando banco de dados..."

until mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" --skip-ssl -e "SELECT 1" >/dev/null 2>&1; do
  echo "Banco ainda não disponível..."
  sleep 2
done

echo "Banco disponível."


ln -s storage/app/public public/storage

php artisan migrate --force
php artisan db:seed --force

php artisan serve --host=0.0.0.0 --port=8000