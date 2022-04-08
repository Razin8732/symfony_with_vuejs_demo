# Project Setup 
### Clone Reposetory
- `git clone https://github.com/RazinTeqB/symfony_with_vuejs_demo.git`

### Install composer package
- `Composer install`

### Update the database connection in .env file
- `Ex: DATABASE_URL="mysql://root:1234@127.0.0.1:3306/sfv_demo?serverVersion=5.7&charset=utf8mb4"`

### Run the database migration
- `php bin/console doctrine:schema:update --force`

### Start symfony server
- `symfony server:start -d`

### Install node packages
- `sudo yarn install`

### Build the frontend
- `sudo yarn watch`





# Extras
### To Install required (specific) vue packages .

    `yarn add vue@^2.5 vue-loader@^15.9.5 vue-template-compiler --dev`
