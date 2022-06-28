#!/usr/bin/env bash
docker run -it --rm --name calculator-api-server -v %cd%:/usr/src/myapp -w /usr/src/myapp -p 9191:9191 php:7.4-cli-alpine php -S 0.0.0.0:9191 public/index.php
