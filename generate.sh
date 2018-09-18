#!/usr/bin/env bash
composer update
yarn upgrade
php generate.php

cp -r node_modules/@fortawesome/fontawesome-free/css/all.min.css assets/css/all.min.css
cp -r node_modules/@fortawesome/fontawesome-free/webfonts assets
