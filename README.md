# 📚 Livrestoire

Une application web Symfony pour découvrir et explorer l'histoire à travers une chronologie interactive d'événements et de périodes historiques.

## 🎯 À propos du projet

**Livrestoire** est une plateforme pédagogique permettant de :
- 📖 Consulter une chronologie d'événements historiques
- 🔍 Découvrir des détails sur chaque événement
- 📅 Explorer les différentes périodes historiques
- ⚙️ Gérer le contenu historique via une interface d'administration

## 🛠️ Technologies utilisées

### Backend
- **Framework** : Symfony 6.4.*
- **ORM** : Doctrine 3.3
- **Langage** : PHP 8.1+
- **Base de données** : MySQL/PostgreSQL (via Doctrine)

### Frontend
- **Moteur de templates** : Twig
- **Framework CSS** : Bootstrap
- **Composants** : Stimulus & Symfony UX Autocomplete

### DevOps
- **Tests** : PHPUnit
- **Gestion des dépendances** : Composer

## 📋 Prérequis

- Composer (pour l'installation locale)
- PHP 8.1 ou supérieur (installation locale)
- Git

## 🚀 Installation et démarrage

### Option 1 : Avec Docker (Recommandé)

1. **Cloner le projet**
```bash
git clone <repository-url>
cd livrestoire
```

2. **Démarrer les conteneurs**
```bash
docker-compose up -d
```

3. **Installer les dépendances PHP**
```bash
docker-compose exec app composer install
```

4. **Créer et configurer la base de données**
```bash
docker-compose exec app php bin/console doctrine:database:create
docker-compose exec app php bin/console doctrine:migrations:migrate
```

5. **Installer les dépendances frontend**
```bash
docker-compose exec app npm install
```

6. **Accéder à l'application**
- Frontend : http://localhost:8000
- Adminer (gestion BD) : http://localhost:8080

### Option 2 : Installation locale

1. **Cloner le projet**
```bash
git clone <repository-url>
cd livrestoire
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configurer l'environnement**
```bash
cp .env .env.local
# Éditer .env.local avec vos paramètres de BD
```

4. **Créer la base de données**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. **Démarrer le serveur**
```bash
symfony serve
```

L'application sera accessible sur http://localhost:8000

## 📁 Structure du projet

```
livrestoire/
├── src/
│   ├── Controller/          # Contrôleurs de l'application
│   │   ├── HomeController.php
│   │   └── Admin/           # Interface d'administration
│   ├── Entity/              # Entités Doctrine
│   │   ├── Events.php
│   │   └── Periods.php
│   ├── Form/                # Formulaires Symfony
│   │   ├── EventsType.php
│   │   └── PeriodsType.php
│   ├── Repository/          # Repositories Doctrine
│   │   ├── EventsRepository.php
│   │   └── PeriodsRepository.php
│   └── Kernel.php
├── templates/               # Templates Twig
│   ├── base.html.twig
│   ├── home/
│   ├── Admin/
│   └── partials/
├── config/                  # Configuration Symfony
│   ├── routes.yaml
│   ├── services.yaml
│   └── packages/
├── migrations/              # Migrations Doctrine
├── assets/                  # Assets frontend (CSS, JS)
│   ├── styles/
│   ├── controllers/
│   └── app.js
├── public/                  # Dossier web root
├── tests/                   # Tests PHPUnit
├── docker-compose.yaml      # Configuration Docker
└── composer.json            # Dépendances PHP
```

## 🗄️ Entités principales

### Events (Événements)
Représente un événement historique avec :
- **chronos** : Date/période de l'événement (100 caractères max)
- **title** : Titre de l'événement (100 caractères max)
- **description** : Détails complets de l'événement (1000 caractères max)

### Periods (Périodes)
Représente une période historique avec :
- **name** : Nom de la période (50 caractères max)


## 🔧 Configuration

### Fichiers de configuration importants
- `.env.local` : Variables d'environnement (DB, mailer, etc.)
- `config/packages/` : Configuration des bundles
- `config/services.yaml` : Configuration des services

### Variables d'environnement essentielles
```env
DATABASE_URL=mysql://user:password@localhost:3306/livrestoire
APP_ENV=dev
APP_DEBUG=true
```

## 📦 Dépendances clés

### Backend
- **symfony/framework-bundle** : Framework principal
- **symfony/form** : Gestion des formulaires
- **symfony/validator** : Validation des données
- **doctrine/orm** : ORM pour la base de données
- **knplabs/knp-paginator-bundle** : Pagination
- **symfony/security-bundle** : Authentification et sécurité

### Frontend
- **@hotwired/stimulus** : Framework JavaScript léger
- **tom-select** : Select customisé
- **bootstrap** : Framework CSS

## 🚢 Déploiement

### Docker
L'application est configurée pour être déployée via Docker :

```bash
docker-compose up -d
```

### Considérations de production
- Mettre `APP_DEBUG=false` dans `.env.local`
- Configurer un proxy web (Nginx/Apache)
- Utiliser une base de données de production robuste
- Mettre en place SSL/TLS
- Configurer les sauvegardes de base de données

## 📝 Conventions du projet

- **Langage des commentaires** : Français
- **Langage des validations** : Français
- **Architecture** : MVC (Model-View-Controller)
- **Migrations** : Versionné avec Doctrine Migrations

## 🐛 Troubleshooting

### La base de données ne se crée pas
```bash
docker-compose exec app php bin/console doctrine:database:create
```

### Les migrations ne s'exécutent pas
```bash
docker-compose exec app php bin/console doctrine:migrations:migrate
```

### Problèmes de permissions
```bash
docker-compose exec app chmod -R 755 var/
```

## 📞 Support

Pour toute question ou problème, veuillez consulter la documentation Symfony :
- [Symfony Documentation](https://symfony.com/doc/current/index.html)
- [Doctrine Documentation](https://www.doctrine-project.org/projects/doctrine-orm/en/current/index.html)

## 📄 Licence

Ce projet est licencié sous la Licence MIT.

### Licence MIT

Copyright (c) 2026 Alexis Bessac

La permission est accordée par la présente, gratuitement, à toute personne obtenant une copie de ce logiciel et des fichiers de documentation associés (le "Logiciel"), de traiter le Logiciel sans restriction, y compris sans limitation des droits d'utilisation, de copie, de modification, de fusion, de publication, de distribution, de sous-concession et/ou de vente de copies du Logiciel, et de permettre aux personnes à qui le Logiciel est fourni de le faire, sous réserve des conditions suivantes :

L'avis de copyright ci-dessus et cet avis de permission doivent être inclus dans toutes les copies ou parties substantielles du Logiciel.

LE LOGICIEL EST FOURNI "TEL QUEL", SANS GARANTIE D'AUCUNE SORTE, EXPRESSE OU IMPLICITE, Y COMPRIS MAIS NON LIMITED AUX GARANTIES DE QUALITÉ MARCHANDE, D'ADAPTATION À UN USAGE PARTICULIER ET D'ABSENCE DE CONTREFAÇON. EN AUCUN CAS LES AUTEURS OU DÉTENTEURS DE DROITS D'AUTEUR NE SERONT RESPONSABLES DE TOUTE RÉCLAMATION, DOMMAGE OU AUTRE RESPONSABILITÉ, QUE CE SOIT DANS LE CADRE D'UNE ACTION CONTRACTUELLE, DÉLICTUELLE OU AUTRE, DÉCOULANT DE, HORS DE OU EN LIEN AVEC LE LOGICIEL OU L'UTILISATION OU D'AUTRES TRANSACTIONS DANS LE LOGICIEL.

---

**Dernière mise à jour** : février 2026
