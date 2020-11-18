FROM nginx:alpine

COPY ./default.conf /etc/nginx/conf.d/mysite.template

RUN apk add --no-cache openssl
RUN mkdir /etc/nginx/ssl 2> /dev/null
RUN openssl genrsa -out "/etc/nginx/ssl/default.key" 2048 \
    && openssl req -new -key "/etc/nginx/ssl/default.key" -out "/etc/nginx/ssl/default.csr" -subj "/CN=default/O=YOURCOMPANYNAME/C=UK" \
    && openssl x509 -req -days 365 -in "/etc/nginx/ssl/default.csr" -signkey "/etc/nginx/ssl/default.key" -out "/etc/nginx/ssl/default.crt"

WORKDIR /var/www/html