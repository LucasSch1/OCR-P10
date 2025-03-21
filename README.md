# 🚀 Installation du projet P10

## 📥 1. Cloner le projet
Clonez le dépôt sur votre machine locale :
```bash
git clone https://github.com/LucasSch1/P10.git
cd P10
```
## ⚙️ 2. Installer les dépendances
Exécutez la commande suivante pour installer les dépendances PHP :
```bash
composer install
```
Attendez la fin du téléchargement et de l’installation des ressources.

## 🛠 3. Configurer la base de données
Modifiez le fichier **.env** pour **renseigner vos identifiants de connexion à la base de données.** 

Voici la configuration attendue :
```bash
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```
**⚠️ Remplacez app et !ChangeMe! par votre identifiant et votre mot de passe réel si nécessaire ainsi que la version de votre base de données.**

## 🏗 4. Créer et appliquer la base de données
➤ Créer la base de données :
```bash
php bin/console doctrine:database:create
```
➤ Appliquer la migration à la base de données :
```bash
php bin/console doctrine:migrations:migrate
```
**Confirmez en tapant yes si demandé.**

➤ Créer une migration (**si celle présente ne fonctionne pas**) :
```bash
php bin/console doctrine:migrations:diff
```

## ✅ 5. Vérifier la synchronisation du schéma
Assurez-vous que la base de données est bien en phase avec les entités :
```bash
php bin/console doctrine:schema:validate
```
Si tout est correct, vous devriez voir :

**Mapping   OK**

**Database  OK**

Les messages doivent s'afficher en vert ✅.

## 🗄 6. Ajouter des données de test
Chargez les fixtures (données de test) dans la base de données :
```bash
php bin/console doctrine:fixtures:load
```
**Confirmez en tapant yes si demandé.**


## 🚀 7. Lancer le serveur web
Démarrez le serveur Symfony en arrière-plan :
```bash
symfony serve -d
```
Cliquez ensuite sur le **lien affiché dans la console pour accéder au projet.**



