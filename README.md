# 🚀 Neat_Pro - Tableau de Bord Admin Complet

[![Laravel](https://img.shields.io/badge/Laravel-12-orange.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4-green.svg)](https://tailwindcss.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple.svg)](https://getbootstrap.com)
[![License MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

## 📖 Description

**Neat_Pro** est une application Laravel moderne et complète de **tableau de bord d'administration** (Admin Dashboard). Conçue pour gérer efficacement une activité e-commerce/CRM, elle offre une interface intuitive avec :

- **Dashboard analytique** avec statistiques en temps réel
- **Gestion CRM** (clients, commandes)
- **E-commerce** (produits, transactions)
- **Analytics** avec graphiques
- **Notifications** et exports PDF
- **Gestion utilisateurs** (rôles, authentification sociale)
- **Support multilingue** : Français 🇫🇷, Anglais 🇺🇸, Arabe 🇦🇪

Parfait pour les startups, PME ou projets de démonstration. Démo data incluse via seeders !

## ✨ Fonctionnalités Principales

| Module | Description |
|--------|-------------|
| 🏠 **Dashboard** | Statistiques globales, graphiques (ventes, revenus) |
| 👥 **CRM** | Gestion clients & commandes avec recherche/filtres |
| 🛒 **E-commerce** | Catalogue produits, transactions bancaires |
| 📊 **Analytics** | Rapports détaillés et visualisations |
| 🔔 **Notifications** | Système de notifications app |
| 📋 **Utilisateurs** | Auth (login/register/social), profils, rôles admin/user |
| 📄 **Exports** | PDF des commandes et rapports |
| 🌐 **Multilingue** | EN / FR / AR avec middleware |
| 🔐 **Sécurité** | Laravel Sanctum, rôles middleware |

## 🛠️ Stack Technique

```
Backend: Laravel 12 • PHP 8.2+ • MySQL/PostgreSQL
Frontend: TailwindCSS 4 • Bootstrap 5 • Vite • Blade
Packages: Laravel Socialite • DomPDF • Intervention Image
Base de données: Eloquent ORM • Migrations • Seeders
Autres: Jobs/Queues • Cache • Sessions
```

## 🚀 Installation & Démarrage Rapide

### Prérequis
- PHP 8.2+
- Composer
- Node.js / npm
- MySQL ou autre DB supportée
- Git

```bash
# 1. Cloner le repo
git clone https://github.com/votre-username/neat_pro.git
cd neat_pro

# 2. Installer dépendances PHP
composer install

# 3. Copier env et générer clé
cp .env.example .env
php artisan key:generate

# 4. Configurer DB dans .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=neat_pro
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Migrer et seed data démo
php artisan migrate --seed

# 6. Installer assets JS/CSS
npm install
npm run build

# 7. Lancer le serveur
php artisan serve

# 8. Accéder en ligne
# Ouvrir http://127.0.0.1:8000
# Admin: admin@neatpro.com / password (via seeder)
```

**Compte démo (après seeders):**
- Email: `admin@neatpro.com`
- Password: `password`

## 📱 Captures d'Écran

| Dashboard | CRM | E-commerce |
|-----------|-----|------------|
| ![Dashboard](./public/screenshots/dashboard.png) | ![CRM](./public/screenshots/crm.png) | ![Ecommerce](./public/screenshots/ecommerce.png) |

*(Ajoutez vos screenshots dans `public/screenshots/`)*

## 🌍 Support Multilingue

- `FR` (défaut)
- `EN`
- `AR`

Changer via middleware ou URL paramètre.

## 🤝 Contribution

1. Fork le projet
2. Créer une branche `feature/XXXX`
3. Commit vos changements
4. Push vers la branche
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence [MIT](LICENSE) - gratuit pour usage commercial/personnel.

## 🙏 Remerciements

- [Laravel](https://laravel.com) - Framework incroyable
- [TailwindCSS](https://tailwindcss.com) - UI moderne
- Contributeurs open-source

---

⭐ **Star ce repo si utile !** ⭐

**Auteur:** [Votre Nom]  
**Contact:** votre-email@example.com  
**Démos live:** [Lien vers démo]

