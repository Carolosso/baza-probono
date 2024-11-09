#!/bin/bash
# Change to the project directory
cd /home/parafia-nd/ftp/baza-adopcja

# Run Laravel scheduler
/usr/local/bin/php artisan schedule:run
