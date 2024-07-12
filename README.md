# Test Kalitics fullstack

## Prérequis
* Installer le CLI de symfony
* Préparer une base de donnée SQl (le projet a été créé avec mariaDB)

## Commandes à exécuter
```shell
# Adapter DATABASE_URL dans .env pour votre database SQL
symfony composer install
symfony console doctrine:migrations:migrate

# Pour démarrer le serveur local
symfony serve
```

<!-- Premiere idée

pour saisir les informations du collaborateur une seule fois avant de passer au pointage je pense que un systeme d'authentification et connexion va permettre d'enregostrer ses infos une seule fois
=> donc je rajoute les infos pour rendre cela possible à la table user 
=>aussi role pour la deuxieme partie de l'exercice

Ensuite changer la relation entre la table chantier et pointage en ManyToMany 
pour selectionner plusieurs chantiers et plusieurs durées . Pour cela c'est mieux avoir la durée dans la table intermediaire plutot que dans pointage


Pour la deuxieme partie je pense qu'il faudra gerer les roles des collaborateur et permettre au chef du projet de placer les autre collaborateur sur un chantier . Donc un formulaire specifique accessible sous la condition de role_admin -->