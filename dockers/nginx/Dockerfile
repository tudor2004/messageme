# Pull the nginx alpine image
FROM nginx:1.14-alpine

LABEL authors="Tudor-Dan Ravoiu <tudor2004@yahoo.com>"
LABEL org.label-schema.build-date=$BUILD_DATE
LABEL org.label-schema.vcs-ref=$VCS_REF

# Add config files
COPY ./dockers/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

# Configure the timezone
RUN apk --no-cache add tzdata \
    && cp /usr/share/zoneinfo/Europe/Berlin /etc/localtime \
    && echo "Europe/Berlin" > /etc/timezone \
    && apk del tzdata

# Check the date is output correctly
RUN date

COPY web /srv/app/web/

RUN chmod 777 -R /var/log/

EXPOSE 80