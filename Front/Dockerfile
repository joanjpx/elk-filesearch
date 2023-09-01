FROM gnbit/php8.1-elk

#COPY ./file-insight /usr/local/

# Set the working directory
WORKDIR /var/www

# Environment variables
ENV ES_API_URI=https://192.168.10.75:9200
ENV ES_API_USER=elastic
ENV ES_API_PASS=gnbit123
ENV ES_INDEX=afiles
ENV PATH_SCRIPTS=/var/www/file-insight/scripts 