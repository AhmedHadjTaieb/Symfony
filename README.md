# Sommaire
- [Introduction](#introduction)
- [Pre-requise](#Pre-requise)
- [Virtual environment](#virtual-environment)
- [Usage](#usage)
- [Params](#Params)

# Introduction
This project provide a simple installation of opclroom Sites with Symfony v3.4.

## Git global setup:
```bash
git config --global user.name "FirstName SecondName"
git config --global user.email "yourmail@sifast.com"
git clone https://github.com/AhmedHadjTaieb/Symfony.git
```

# Pre-requise
 * Docker
 * Docker Compose
 * Create Virtual Host
 ```bach
sudo nano /etc/hosts
 ```

# Virtual-environment
This project create a virtual environment composed by :
 * [Mysql](https://hub.docker.com/_/mysql/) 8 container
 * [phpmyadmin](https://hub.docker.com/r/phpmyadmin/phpmyadmin/) latest container
 * [php](https://hub.docker.com/_/php/) 7.2-apache

# Usage
 To start developpement environnement run this command :
 
Using ACL on a System that Supports setfacl
```bach
./ENV/start_dev.sh
```
Using ACL on a System that Supports chmod +a
```bach
*First Step:
 (Add these lines in ./ENV/entrypoint.sh)
 rm -rf var/cache/*
 rm -rf var/logs/*

 HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
 sudo chmod +a "$HTTPDUSER allow delete,write,append,file_inherit,directory_inherit" var
 sudo chmod +a "$(whoami) allow delete,write,append,file_inherit,directory_inherit" var
 
*Second Step:
cd <PROJECT_PATH>./ENV/
docker-compose --project-name opclroom -f docker-compose.yml up --build -d 
```

# Params
 * PhpMyAdmin:
 ```
   Utilisateur : root
   Mot de passe : root
   Database : opclroom
 ```
