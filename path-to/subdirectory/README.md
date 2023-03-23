# Project Restaurant ECF

Un projet symfony
Déployez en local
Clonez le projet sur votre ficher htdocs de xampp .

Ajoutez les fichiers de configuration des variables d'environnement (.env, .env.local).

Ce projet nécessite le paramétrage de APP_ENV, APP_SECRET, DATABASE_URL 

## Installation

Pour installer les dépendances de symfony pour ce projet, lancez la commande :
Install my-project with npm

```bash
  composer install
```
Pour servir votre application, lancez la commande :
```bash
    symfony server:start
```

Pensez également à activer MySQL sur xampp pour que votre base de données soit accessible.

Ouvrez votre navigateur sur http://localhost:8000/


Pour plus d'informations, vous pouvez lire la documentations symfony : [Symfony Setup](https://symfony.com/doc/current/setup.html)

Pour la première utilisation j'ai créer deux utilisateurs un admin (email:admin@admin.fr mtp:admin) et un utlisateur (email:user@user.fr mtp:user).

Pour creer un utilisateur il suffit de cliquer sur l'onglet "Mon compte" puis sur register et entrer les données, pour l'administrateur il faut que l'admin@admin soit authentifié puis sur l'adresse http://localhost:8000/admin/add qui permettra d'ajouter un nouvel administrateur.

### A venir

- Cacher le bouton administration aux utilisateurs non admin ✅
- Afficher les horaires uploader par l'admin
- Afficher les photos uploader par l'admin sur la page d'accueil ✅
- Gérer la reservation par le client ainsi que le nombre de place restante pour le restaurant.
- Déployez en ligne (sur Heroku)
Pour le déploiement en ligne, il vous suffira de créer un compte Heroku (gratuit). Une fois le projet cloner sur un compte github, la connection peut être établie de diverses façons:

Par les CLI heroku depuis la console .
En automatisant le déploiement sur la branche principale de votre github. Pour cela il faudra choisir l'option adéquate depuis le dashboard de Heroku dans l'onglet deploy. *

Attention, les variables d'environnement (APP_ENV, APP_SECRET, DATABASE_URL ET MAILER_DSN) seront à paramétrer dans l'onglet settings (cliquez sur Reveal Config Vars) et n'oubliez pas d'ajouter le build pack heroku/php. Dans l'onglet Resources vous ajouterez l'Add-on de base de données.



### 🔗 Links

[![Github](https://img.shields.io/badge/Github-0A66C2?style=for-the-badge&logo=Github&logoColor=white)](https://github.com/DdLgc/ECF)  
[![Figma](https://img.shields.io/badge/Figma-0A66C2?style=for-the-badge&logo=Figma&logoColor=black)]([https://github.com/DdLgc/ECF](https://www.figma.com/file/kdYcppoQYfiPKr8Tga1SJ3/Wireframe-CH-ECF-restaurant?node-id=2-3&t=UdgFTRAn5bCHLyTd-0))


[Documentation](https://github.com/DdLgc/ECF/tree/dev/Documents%20complementaires)
