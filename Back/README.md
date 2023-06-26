# Project DiscO'Tech - BackEnd

## About

The project consists in creating an online platform allowing the referencing of all musical genres

The main goal is to provide users with a friendly and attractive interface to explore music discs.

## Deploy

- Launch VM Cloud by [kourou](https://kourou.oclock.io/ressources/vm-cloud/) and wait for starting
- Copy your SSH command `ssh student@xxxxxxxxxxxxxxxx-server.eddi.cloud`
- Open new BASH, paste and execute your SSH command

## Checklist Deploy

- Place you in the folder HTML and clone this repository

```bash
cd /var/www/html
git clone git@github.com:xxxxxxxxxx.git
```

- Now place you inside the project folder
  
```bash
cd projet-disc-otech-back/Back
```

- Composer installation:
```bash
composer install
```

- Configure `.env.local` file
```bash
nano .env.local
```
### Configuration
**Warning**: You need to use your `LOGIN` and `PASSWORD` who they have all permission on the database and modify this URL (without { })

```bash
DATABASE_URL="mysql://{LOGIN}:{PASSWORD}@127.0.0.1:3306/{DATABASE_NAME}?serverVersion=mariadb-10.3.38&charset=utf8mb4"
```

After that, you can `ctrl + X`, response `y` and if it's ok for you and press `enter`

### Creation of the database and configuration 

- create the database : `bin/console doctrine:database:create`
- creation of the database structure : `bin/console doctrine:migrations:migrate`
- Launch fixtures : `bin/console doctrine:fixtures:load`
- Generate token JWT `bin/console lexik:jwt:generate-keypair`

### Switch to PROD

- Now you can switch to prod environment with `nano .env.local`

```ini
APP_ENV=prod
```
and then: `ctrl + X`, response `y` and if it's ok for you and press `enter`

### Cache clear

```bash
bin/console cache:clear
```
***
if **Cache clear Error** : **Unable to write in the "/var/www/html/project-disc-otech/Back/var/cache/prod" directory**:

- Execute `sudo chmod -R 775 var/cache/prod` (this command is dangerous because she modify access to this folder => do not execute if you don't have this error!)
  
- Execute `bin/console cache:clear`

you should have the answer:
**[OK] Cache for the "prod" environment (debug=false) was succesfully cleared.**

Now you can try the connection with the server:
* if the server is OK you can skip the next command
* but if the server does not respond (error 500),       
  * execute: `sudo chown -R www-data:$USER var/cache/prod`
  * Write your password when it's required (you can find your password on [kourou](https://kourou.oclock.io/ressources/vm-cloud/))

***

To finish, don't forget to modify the base URL in the .env file in your front repository.

That's all, enjoy :)