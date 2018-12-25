# Sommaire
- [Introduction](#introduction)
- [Pre-requise](#Pre-requise)
- [Virtual environment](#virtual-environment)
- [Usage](#usage)
- [Params](#Params)

# Introduction
This project provide a simple installation of opclroom Sites with Symfony v3.4.

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
```bach
cd <PROJECT_PATH>./ENV/

docker-compose --project-name opclroom -f Docker-compose.yml up --build -d 

```

# Params
 * PhpMyAdmin:
 ```
   Utilisateur : root
   Mot de passe : root
   Database : opclroom
 ```
