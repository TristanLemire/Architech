# Architech
Projet fin d'année de web3 (API)

### Basic commands

install dependencies:

#### Normal

```shell script
composer install
```

#### Makefile

```shell script
make install
```

---

Create the Database:

#### Normal

```shell script
./bin/console doctrine:database:create
```

#### Makefile

```shell script
make db-create
```

---

Execute the last migration:

#### Normal

```shell script
./bin/console doctrine:migration:migrate
```

#### Makefile

```shell script
make db-migration
```

---

Launch the server:

#### Normal

```shell script
symfony server:start
```

#### Makefile way

```shell script
make start
```

Stop the server:

```shell script
make stop
```

---
