FROM node:20.11.1-alpine

EXPOSE 4200

# RUN apk update

# RUN apk add rsync

RUN npm update -g npm

RUN npm install -g @angular/cli

# WORKDIR /var/www/cache

WORKDIR /var/www/app

COPY package*.json .

RUN npm install --force

# WORKDIR /var/www/app

COPY . .

# RUN chmod +x commands.sh

# CMD ["./commands.sh"]

CMD ["ng", "serve", "--host", "0.0.0.0"]