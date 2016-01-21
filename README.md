# Instant Pics project
**created by Alan RIDARD & Louis MANGAND**

## Introduction
------------
C'est une application skeletton simple, se basant sur un MVC avec des modules d'uathentification et d'image.
Cette application permet de partager des images via un compte.

## Installation 
---------------------------

- Télécharger le projet depuis le tag github ou la branch Master et le mettre dans le fichier racine de votre serveur */www/ pour wampServer* ou */xamp/htdoc/ pour Xamp*

##### Installer composer :
- Commencer par vous déplacer depuis la console jusqu'au répertoire ou se trouve votre application
- Taper ensuite la commande d'installation composer : *composer install* -- Attendre la fin de l'installation
- Par mesure préventive vous pouvez taper : "composer update"

#####  Installer la base de donnée :
- Prendre le fichier BDD.sql dans le répertoire Source
- Vous pouvez, si une surcouche (ex: phpMyAdmin) est présente sur votre serveur, importer ce fichier sur votre serveur pour générer la base de donnée
- Dans phpMyAdmin, il existe un onglet "importer" qui vous permet directement d'importer la base de données
**OU**
- Vous pourrez l'ouvrir avec un éditeur de texte et vous servir des données pour générer votre base de données vous même 
- Pensez bien à appeler le Schema "zend2" placer les tables dans ce Schema
- Si votre connexion à votre base de donnée s'ouvre avec un mot de passe et/ou a un login différent de *root*, veuillez modifier le fichier *global.php* situé dans */config/autoload/global.php*

- Vous pouvez maintenant vous rendre sur votre navigateur pour ouvrir le chemin allant jusqu'à votre application

## En cas de problème

- Refaire l'installation du début et/ou vérifier que composer s'est installé correctement

- Vous pouvez me contacter par mon adresse mail : alan.ridard@gmail.com

