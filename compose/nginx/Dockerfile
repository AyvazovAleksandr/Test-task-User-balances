FROM nginx:1.23.2-alpine

ARG UID=1000
ARG GID=1000



# ADD Custom Config
ADD ./compose/nginx/nginx.conf /etc/nginx/nginx.conf
ADD ./compose/nginx/default.conf /etc/nginx/conf.d/default.conf

# Make Directory - Workspace
RUN mkdir -p /var/www/html


# ADD and set Group
# new code
RUN addgroup -g $GID laravel \
    && adduser -u $UID -G laravel -s /bin/sh -D laravel

# Set Group to Workspace
RUN chown -R laravel:laravel /var/www/html