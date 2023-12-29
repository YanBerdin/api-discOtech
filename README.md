# Project DiscO'Tech - BackEnd
## https://api-discotech-v2-8ef81b7469dd.herokuapp.com/login
## :man_dancing: About

The project consists in creating an online platform allowing the referencing of all musical genres

The main goal is to provide users with a friendly and attractive interface to explore music discs.

## :gear: Deploy

- Launch VM Cloud by Scholl Server and wait for starting
- Copy your SSH command `ssh student@xxxxxxxxxxxxxxxx-server.eddi.cloud`
- Open new BASH, paste and execute your SSH command

## :heavy_check_mark: Checklist Deploy

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
### :hammer: Configuration
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
### Apache Config

- Enable rewrite module: `sudo a2enmod rewrite`

```bash
Enabling module rewrite.
To activate the new configuration, you need to run:
  systemctl restart apache2
```

it asks us to restart the apache server

```bash
systemctl restart apache2
==== AUTHENTICATING FOR org.freedesktop.systemd1.manage-units ===
Authentication is required to restart 'apache2.service'.
Multiple identities can be used for authentication:
 1.  Ubuntu (ubuntu)
 2.  aurelien
 3.  spada
 4.  hdg
 5.  christophe
 6.  student
Choose identity to authenticate as (1-6): 6
Password:
==== AUTHENTICATION COMPLETE ===
```

- We are going to tell him to authorize the reading of .htaccess files

```bash
sudo nano /etc/apache2/apache2.conf
```

We scroll to `<Directory /var/www/>` (7 times page down) and modify that:

```bash
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
```

by:

```bash
 <Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride all
        Require all granted
</Directory>
```
and then: `ctrl + X`, response `y` and if it's ok for you and press `enter`

- Restart the apache server

```bash
systemctl restart apache2
==== AUTHENTICATING FOR org.freedesktop.systemd1.manage-units ===
Authentication is required to restart 'apache2.service'.
Multiple identities can be used for authentication:
 1.  Ubuntu (ubuntu)
 2.  aurelien
 3.  spada
 4.  hdg
 5.  christophe
 6.  student
Choose identity to authenticate as (1-6): 6
Password:
==== AUTHENTICATION COMPLETE ===
```

***
To finish, don't forget to modify the base URL in the .env file in your front repository.

That's all, enjoy :)
