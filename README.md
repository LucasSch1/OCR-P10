# 🚀 Installation du projet P10

## 📥 1. Cloner le projet
Clonez le dépôt sur votre machine locale :
```bash
git clone https://github.com/LucasSch1/OCR-P10.git
cd OCR-P10
```
## 🛠 2. Configurer la base de données
Modifiez le fichier **.env** pour **renseigner vos identifiants de connexion à la base de données.** 

Voici la configuration attendue :
```bash
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```
**⚠️ Remplacez app et !ChangeMe! par votre identifiant et votre mot de passe réel si nécessaire ainsi que la version de votre base de données.**

## ⚙️ 3. Installer les dépendances
Exécutez la commande suivante pour installer les dépendances PHP :
```bash
composer install
```
Attendez la fin du téléchargement et de l’installation des ressources.

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

### 🔑 Connexion avec les comptes fixtures
Après avoir chargé les fixtures, vous pouvez utiliser les comptes suivants pour vous connecter :

| Email            | Mot de passe |
|------------------|--------------|
| admin@dix.com    | admin        |
| user1@dix.com    | user1        |
| user2@dix.com    | user2         |



## 🚀 7. Lancer le serveur web
Démarrez le serveur Symfony en arrière-plan :
```bash
symfony serve -d
```
Cliquez ensuite sur le **lien affiché dans la console pour accéder au projet.**

# 🧪 Tester l'application

## 👤 S’inscrire
Vous pouvez aussi créer de nouveaux comptes via la page d'inscription affichée sur le site.

## 🔐 Se connecter avec double authentification (2FA)
Après l'inscription, connectez-vous. Une étape de configuration du système 2FA (double authentification) peut être nécessaire selon les paramètres de sécurité du projet. Suivez les instructions affichées pour activer et utiliser la 2FA (Google Authenticator).

## 🎭 Changer le rôle d’un utilisateur dans la base de données
Par défaut, un utilisateur a le rôle `ROLE_USER` (équivalent à **Collaborateur**).  
Pour tester l’accès d’un **Chef de projet**, modifiez manuellement le rôle en `ROLE_ADMIN` dans la base de données.


