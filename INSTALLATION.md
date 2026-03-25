# Guide d'Installation - SantéPlus

## 📦 Étapes d'Installation

### 1. Configuration de la Base de Données

Éditez le fichier `.env` à la racine du projet et configurez `DATABASE_URL` :

**Pour MySQL/MariaDB :**
```env
DATABASE_URL="mysql://root:password@127.0.0.1:3306/santeplus?serverVersion=8.0"
```

**Pour SQLite (plus simple pour débuter) :**
```env
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```

### 2. Créer la Base de Données

```bash
php bin/console doctrine:database:create
```

### 3. Créer les Tables (Migrations)

```bash
php bin/console doctrine:migrations:migrate
```

### 4. Charger les Données de Test

Cette commande crée 3 médecins de test dans la base de données :

```bash
php bin/console app:load-medecins
```

### 5. Lancer le Serveur

**Avec Symfony CLI :**
```bash
symfony server:start
```

**Avec PHP intégré :**
```bash
php -S localhost:8000 -t public
```

Le site sera accessible sur : `http://localhost:8000`

## ✅ Vérification

Une fois le serveur lancé, vous devriez pouvoir accéder à :

- **Accueil** : http://localhost:8000/
- **Médecins** : http://localhost:8000/medecins
- **Rendez-vous** : http://localhost:8000/rendez-vous
- **Connexion** : http://localhost:8000/login

## 🔐 Test de Connexion

- **Nom d'utilisateur** : `anas`
- **Mot de passe** : `1234`

## 📝 Notes Importantes

- Le design HTML/CSS original est conservé à 100%
- Toutes les classes CSS sont préservées
- Le projet utilise Symfony 6 et PHP 8
- Les assets (CSS, JS, images, vidéo) sont dans `public/`

## 🐛 Problèmes Courants

**Erreur de base de données :**
- Vérifiez que MySQL/MariaDB est démarré
- Vérifiez les identifiants dans `.env`

**Erreur de permissions :**
- Assurez-vous que le dossier `var/` est accessible en écriture

**Erreur de cache :**
- Videz le cache : `php bin/console cache:clear`

