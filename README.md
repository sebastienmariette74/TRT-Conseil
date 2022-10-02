# Evaluation TRT Conseil

# Sommaire

* [Détails du projet](#détails-du-projet)
* [Guide d'utilisation](#guide-dutilisation)
* [Déploiement](#déploiement)
* [Installation en local](#installation-en-local)
* [Questions et réflexions](#questions-et-réflexions)

# Détails du projet

## Objectifs

L’objectif du projet est de mener une étude (Analyse des besoins) et développer l’application web présentée ci-dessous.
Il convient également d’élaborer un dossier d’architecture web qui documente entre autres les choix des technologies,
les choix d’architecture web et de configuration, les bonnes pratiques de sécurité́ implémentées, etc.

Il est également demandé d’élaborer un document spécifique sur les mesures et bonnes pratiques de sécurité́ mises en
place et la justification de chacune d’entre elles. Les bases de données et tout autre composant nécessaire pour faire
fonctionner le projet sont également accompagnés d’un manuel de configuration et d’utilisation.

## Exigences

TRT Conseil est une agence de recrutement spécialisée dans l’hôtellerie et la restauration. Fondée en 2014, la société s’est agrandie au fil des ans et possède dorénavant plus de 12 centres dispersés aux quatre coins de la France.

La crise du coronavirus ayant frappé de plein fouet ce secteur, la société souhaite progressivement mettre en place un outil permettant à un plus grand nombre de recruteurs et de candidats de trouver leur bonheur.

TRT Conseil désire avoir un produit minimum viable afin de tester si la demande est réellement présente. L’agence souhaite proposer pour l’instant une simple interface avec une authentification.

## cible

L’interface sera utilisée par des candidats, des recruteurs, des consultants et un administrateur.

## Descriptions des fonctionnalités

- Créer son compte

    *Utilisateurs concernés : recruteurs, candidats*

    -  L’utilisateur devra renseigner un email valide et un mot de passe sécurisé.
    - Avant que le compte soit actif, un consultant devra approuver la demande de création.

- Se connecter

    *Utilisateurs concernés : recruteurs, candidats, consultants, administrateur*

- Créer un consultant

    *Utilisateurs concernés : administrateur*

- Compléter son profil

    *Utilisateurs concernés : candidats, recruteurs*

    - Les candidats pourront préciser leur nom, prénom ainsi que transmettre leur CV (obligatoirement au format PDF).

    - Les recruteurs pourront préciser le nom de l’entreprise ainsi qu’une adresse.

- Publier une annonce

    *Utilisateurs concernés : recruteurs*

    - Un formulaire devra demander l’intitulé du poste, le lieu de travail et une description détaillée (horaires, salaire, etc.).

    - Un consultant doit valider l’annonce avant qu’elle soit visible pour les candidats.

    - Pour chaque offre qu’il a transmise, une liste des candidats validés par TRT Conseil et qui ont postulés à cette annonce sera visible par le recruteur.

- Postuler à une annonce

    *Utilisateurs concernés : candidats*

    - Depuis la liste de toutes les annonces disponibles sur l’application, un candidat peut postuler à une offre en appuyant sur un simple bouton.

    - Un consultant doit approuver ou non la démarche.

    - Si c’est approuvé, le recruteur concerné recevra un email avec le nom/prénom du candidat ainsi que son CV.


# Guide d'utilisation

Le guide d'utilisation se trouve dans le dossier ```annexes```.

Vous pouvez également cliquer sur
ce [lien](https://github.com/sebastienmariette74/TRT-Conseil/blob/main/annexes/guide%20d'utilisation.pdf).

# Déploiement

## Environnement de développement

### Pré-requis

* PHP 8.1
* Symfony 6.1
* Composer
* Symfony CLI
* nodejs et npm

Vous pouvez vérifier les pré-requis avec la commande suivante (de la CLI Symfony) :

```bash
symfony check:requirements
```

Cette application comprend l'envoi de mails. Pour pouvoir les visualiser en version test, vous pouvez utiliser [mailtrap](https://mailtrap.io/). Il suffit de créer un compte gratuitement.


## Installation en local

Pour installer le projet en local. Vous devez avoir un [environnement de développement](https://symfony.com/doc/current/setup.html) correctement configuré.

### Etapes

* Créer votre dossier de travail et cloner le projet.
    ```
    git clone https://github.com/sebastienmariette74/TRT-Conseil.git
    ```
* Créer une copie du .env en le nommant .env.local et modifier le fichier .env.local afin de le rendre compatible avec votre environement. Y intégrer votre propre variable d'environnement ```DATABASE_URL``` ainsi que la variable ````MAILER_DSN```` de votre choix.

* Installer les dépendances php
    ```
    composer install
    ```
* Installer les dépendances javascript
    ```
    npm install
    ```
* Exécuter les migrations sur la base de données
    ```
    php bin/console doctrine:database:create
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    ```
* Créer un compte administrateur en lançant les fixtures
    ```
    symfony console doctrine:fixtures:load --no-interaction
    ```

* Compiler le javascript
    ```
    npm run build
    ```
* Lancer le projet
    ```
    symfony server:start
    ```
* S'identifier :

    * email : ````admin@gmail.com````
    * mot de passe : ````admin````

La base de donnée utilisée pour la construction du projet a été exportée et sauvegargée dans le dossier ```annexes```.

## Déploiement sur Heroku

Afin de déployer le projet sur Heroku. Il est important d'avoir créer un compte sur celui-ci.

* Créer une nouvelle aplication avec la cli
    ```
    heroku create (nom de l'appli)
    ```
* Configurer les variables d'environnement
    ```
    heroku config:set APP_ENV=prod
    ```
* Lancer le déploiement
    ```
    git push heroku main
    ```

Pour garantir un déploiement sur Heroku réussi, je vous conseille de passer par le bunddle [nat/deploy](https://packagist.org/packages/nat/deploy). Suivez-les étapes décrites sur le site.

# Questions et réflexions

Le document questions et réflexions se trouve dans le dossier ```annexes```.

Vous pouvez également cliquer sur
ce [lien](https://github.com/sebastienmariette74/TRT-Conseil/blob/main/annexes/questions%20et%20r%C3%A9flexions.pdf) pour le voir.
