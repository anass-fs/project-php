# SantéPlus - Site de Prise de Rendez-vous Médicaux

Projet Symfony 6 / PHP 8 pour un site web de prise de rendez-vous médicaux en ligne.

## 📋 Prérequis

- PHP 8.1 ou supérieur
- Composer
- Symfony CLI (optionnel, pour le serveur de développement)
- Base de données MySQL/MariaDB ou SQLite

## 🚀 Installation

1. **Cloner ou télécharger le projet**

2. **Installer les dépendances**
   ```bash
   composer install
   ```

3. **Configurer la base de données**
   
   Éditez le fichier `.env` et configurez `DATABASE_URL` :
   ```env
   DATABASE_URL="mysql://user:password@127.0.0.1:3306/santeplus?serverVersion=8.0"
   ```
   
   Ou pour SQLite (plus simple pour débuter) :
   ```env
   DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
   ```

4. **Créer la base de données et les tables**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **Charger les données de test (médecins)**
   ```bash
   php bin/console app:load-medecins
   ```

6. **Lancer le serveur de développement**
   ```bash
   symfony server:start
   ```
   
   Ou avec PHP intégré :
   ```bash
   php -S localhost:8000 -t public
   ```

## 📁 Structure du Projet

- `src/Controller/` - Contrôleurs Symfony
- `src/Entity/` - Entités Doctrine (Medecin, Patient, RendezVous)
- `src/Form/` - Formulaires Symfony
- `src/Repository/` - Repositories Doctrine
- `templates/` - Templates Twig
- `public/` - Assets publics (CSS, JS, images, vidéos)

## 🎯 Pages Disponibles

- **Accueil** : `/`
- **Liste des médecins** : `/medecins`
- **Prendre un rendez-vous** : `/rendez-vous`
- **Connexion** : `/login`

## 🔐 Connexion

Pour tester la connexion, utilisez :
- **Nom d'utilisateur** : `anas`
- **Mot de passe** : `1234`

## 📝 Fonctionnalités

- ✅ Affichage de la liste des médecins
- ✅ Formulaire de prise de rendez-vous avec validation
- ✅ Gestion des patients (création automatique si inexistant)
- ✅ Page de connexion
- ✅ Design responsive avec mode sombre/clair
- ✅ Messages de confirmation après soumission

## 🎨 Design

Le design HTML/CSS existant a été conservé à 100%. Toutes les classes CSS originales sont préservées.

## 📚 Technologies Utilisées

- Symfony 6
- PHP 8
- Twig (templates)
- Doctrine ORM (base de données)
- Symfony Forms (formulaires)

## 👨‍💻 Pour les Étudiants

Ce projet est conçu pour être pédagogique et facile à comprendre :
- Code clair et commenté
- Structure simple
- Pas de fonctionnalités avancées inutiles
- Nommage explicite

## 🐛 Résolution de Problèmes

Si vous rencontrez des erreurs :

1. Vérifiez que la base de données est bien configurée
2. Assurez-vous d'avoir exécuté les migrations
3. Vérifiez les permissions sur le dossier `var/`
4. Videz le cache : `php bin/console cache:clear`

## 📄 Licence

Projet pédagogique - Usage libre pour l'apprentissage.

