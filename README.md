# Architech
Projet fin d'année de web3 (API)

## 💪 Équipe Groupe 8 - Back

- Rodrigo Tapia
- Tristan Lemire

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

## Liste des routes disponibles :

### Récupère toutes les prochaines interventions pour un bâtiment donné.
```shell script
`/api/dashboard/futureEvent/<BUILDING_ID>` 
```

### Récupère l'évolution annuelle des incidents pour un bâtiment donné.
```shell script
`/api/dashboard/futureEvent/<BUILDING_ID>` 
```

## Basic commands

### Installer les dépendances:

```shell script
composer install
```

---

### Créer la base de données:

```shell script
./bin/console doctrine:database:create
```

---

### Exécuter les dernières migrations:

```shell script
./bin/console doctrine:migration:migrate
```

---

### Lancer le serveur:

```shell script
symfony server:start
```

### Stopper le serveur:

```shell script
make stop
```

---


## SQL

### Notre MCD 
![alt text](https://github.com/TristanLemire/Architech/blob/main/MCD-MLD/MCD.png "MCD")

### Notre MLD
![alt text](https://github.com/TristanLemire/Architech/blob/main/MCD-MLD/MLD.png "MLD")
