#!/bin/bash
cd /var/www
npm install
npm install pm2 -g
pm2 delete all
pm2 start /var/www/bin/www
