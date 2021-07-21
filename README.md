# Architech

## Quelle est l’objectif du projet ?
Identifier, par un dashboard, les incidents d’un bâtiment scolaire (problème
d’isolation, de température et d’humidité) et de monitorer ces données en temps
réel.

## A quel public se destine-t-il ?
Un établissement scolaire.

## Quelles parties comptez-vous présenter pour le livrable ? Quelles parties seront réalisées et fonctionnelles, quelles parties seront uniquement prototypées, quelles parties ne seront pas traitées ?

### Ce que l’on compte présenter : un tableau de bord destiné à une école comprenant :
- affichage des différents types d’incidents au cours du dernier mois sous
forme de graphique
- affichage détaillé des différents types d’incidents avec leur status (en cours,
assigné à réparation ou terminé) trié par type de capteur
- affichage de l’évolution du nombre d’incidents avec la semaine précédente
- affichage de l’évolution des incidents par mois sur 1 an sous forme de
graphique
- affichage d’un aperçu des réparations à venir (sorte de calendrier)
- affichage des données de l’établissement
- affichage des données en temps réel de ces capteurs par salle

## Ce qui sera prototypé :
- une liste des incidents à examiner (en vue d’une réparation)
- ajouter une date de réparation à un calendrier pour un évènement

## Ce qui ne sera pas traité :
- ajouter/supprimer des capteurs
- ajouter/supprimer des salles de classe
- gestion de paramètres de détection d’incident
- affichage des états des capteurs

## 💪 Équipe Groupe 8

NOM | ROLE
--- | ---
Tristan Lemire | `Back-end`
Rodrigo Tapie | `Back-end`
Emilie Tombouyses | `Front-end`
Virgil Limongi | `Front-end`
Thomas Evano | `Front-end`
Pierre-Alain Agnan | `Front-end`
Selima Ben Kebaier | `Front-end`
Camille Marquand | `Front-end`

## Disclaimer
Ce site a été réalisé à des fins pédagogiques dans le cadre du cursus Bachelor de l’école HETIC. Les contenus présentés
n'ont pas fait l'objet d'une demande de droit d'utilisation. Ce site ne sera en aucun cas exploité à des fins commerciales.

## Projet FRONT 
le projet front -> https://github.com/LimongiVirgil/Architech

## 💻 Installation 💻
- Clonez le projet
- Placez-vous à la racine du projet
- Mettez-vous à la racine du projet et exécutez la commande : `composer install`
- Dans le fichier `.env` modifiez votre `user` et votre `password` par rapport à votre configuration (`DATABASE_URL="mysql://<user>:<password>@127.0.0.1:3306/architech?serverVersion=5.7"`)
- Créez la base de données `./bin/console doctrine:database:create`
- Lancez les migrations `./bin/console doctrine:migrations:migrate`
- Peuplez la base de données `mysql -uroot -p < DB.sql`
- Lancez l'api avec la commande : `symfony server:start`
- Vous pouvez maintenant aller sur `http://127.0.0.1:8000/api`

## Lancer le script des capteurs
- Installer python `brew install python-dev libxml2-dev libxslt-dev`
- Installer pyenv `brew install pyenv pyenv-virtualenv`
- Changer la version de pyenv en 3.9.1 `pyenv install 3.9.1`
- Initialiser pyenv `pyenv init`
- Créer votre environnement `pyenv virtualenv 3.9.1 architech`
- Activer votre environnement `pyenv activate ouihelp-api`
- Installer threading `pip install threading`
- Installer paho-mqtt `pip install paho-mqtt`
- Lancer le script `python3 SENSOR_LITSENER.PY`

## Liste des routes disponibles :

### Récupère toutes les prochaines interventions pour un bâtiment donné.
```shell script
`/api/dashboard/futureEvent/<BUILDING_ID>` 
```

### Récupère l'évolution annuelle des incidents pour un bâtiment donné.
```shell script
`/api/dashboard/futureEvent/<BUILDING_ID>` 
```

## SQL

### Notre MCD 
![alt text](https://github.com/TristanLemire/Architech/blob/main/MCD-MLD/MCD.png "MCD")

### Notre MLD
![alt text](https://github.com/TristanLemire/Architech/blob/main/MCD-MLD/MLD.png "MLD")
