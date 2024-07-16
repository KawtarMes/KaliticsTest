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

1) pour saisir les informations du collaborateur une seule fois avant de passer au pointage je pense que un systeme d'authentification et connexion va permettre d'enregostrer ses infos une seule fois

=> donc je rajoute les infos pour rendre cela possible à la table user(mail, password, token ,active role)
=>make:migration et migrations:migrate

=>fomulaire d'inscription , security controller et authentification

        =>probleme de mailer , en stand by pour gagner du temps (message concernant ssl)
        
Ensuite changer la relation entre la table chantier et pointage en ManyToMany 
pour selectionner plusieurs chantiers et plusieurs durées . Pour cela c'est mieux avoir la durée dans la table intermediaire plutot que dans pointage
  => D'apres mes recherche si je veux rajouter à ma table intermediaire un champs je pourrais pas le faire en symfony. Je dois plutot que de changer la relation,créer une nouvelle table Pointage/Chantier et y mettre le champs durée que je voulais, ainsi que le relier aux tables Pointage et chantier . 


Pour la deuxieme partie je pense qu'il faudra gerer les roles des collaborateur et permettre au chef du projet de placer les autre collaborateur sur un chantier . Donc un formulaire specifique accessible sous la condition de role_admin -->