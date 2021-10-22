# Blog php

Un blog simple en PHP où tout le monde peut soumettre et gérer des articles.

[![Maintainability](https://api.codeclimate.com/v1/badges/04239d7c8539561697da/maintainability)](https://codeclimate.com/github/mdoutreluingne/blog_php/maintainability)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/f613c11f527c44da83cfbb4534976dd9)](https://www.codacy.com/gh/mdoutreluingne/blog_php/dashboard?utm_source=github.com&utm_medium=referral&utm_content=mdoutreluingne/blog_php&utm_campaign=Badge_Grade)

## Installation du projet

Cloner le projet sur votre disque dur avec la commande :
```text
git clone https://github.com/mdoutreluingne/blog_php.git
```

Ensuite, effectuez la commande "composer install" depuis le répertoire du projet cloné, afin d'installer les librairies nécessaires :
```text
composer install
```

### Paramétrage de la base de données

1) Importer la base de données avec le fichier `config/db.sql` en utilisant par exemple phpmyadmin. 
2) Ensuite configurer le fichier `config/db.php` pour la connexion à votre base de données, et remplaçant les valeurs par les vôtres :

````php
<?php
// Le host de votre projet et le nom(dbname) de la base de donnée
define("DB_DSN", "mysql:host=localhost;dbname=blog_php");
// L'identifiant d'accès
define('DB_USER', "root");
// Le mot de passe d'accès
define('DB_PASS', "");
````

### Envoi des mails

Si vous souhaitez utiliser un serveur de mail, afin d'envoyer des mails, vous pouvez le configurer dans `config/mailer.php`.

## Identifiant de connexion

Email : admin.admin@gmail.com
Mot de passe : adminadmin

### Tout est prêt, vous pouvez naviguer sur le site
