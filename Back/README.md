# Project DiscO'Tech - BackEnd

## About

The project consists in creating an online platform allowing the referencing of all musical genres

The main goal is to provide users with a friendly and attractive interface to explore music discs.

## Deploy

- Launch VM Cloud by [kourou](https://kourou.oclock.io/ressources/vm-cloud/) and wait for starting
- Copy your SSH command `ssh student@xxxxxxxxxxxxxxxx-server.eddi.cloud`
- Open new BASH and paste and execute your SSH command

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
### configuration
**Warning**: You need to use your `LOGIN` and `PASSWORD` who they have all permission on the database and modify 

```bash
DATABASE_URL="mysql://{LOGIN}:{PASSWORD}@127.0.0.1:3306/{DATABASE_NAME}?serverVersion=mariadb-10.3.38&charset=utf8mb4"
```
(without { })
