#!/bin/sh
echo "Running commands.sh"
rsync -arv /var/www/cache/node_modules /var/www/app/node_modules
echo "Copied"
cd /var/www/app/
echo "Starting the server..."
npm start