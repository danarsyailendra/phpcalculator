docker run -it --rm --name calculator -v %cd%:/usr/src/myapp -w /usr/src/myapp php:7.3-cli-alpine php app %*
