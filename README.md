#  Jasmine Records
### Site e-commerce de vente d’albums musicaux

---

##  Présentation générale du projet

### 1. Contexte
Dans le cadre du projet de développement web, il s’agit de concevoir une **plateforme e-commerce** permettant la vente d’albums musicaux (**CD, vinyles et albums digitaux**).

Ce projet s’inscrit dans la formation **BTS SIO** et a pour objectif de mettre en pratique les compétences acquises en développement web.

---

### 2. Objectifs du site

####  Objectifs fonctionnels
Permettre à un utilisateur de :
- Consulter un **catalogue d’albums**
- Voir les **détails d’un album**
- Passer une **commande en ligne**

####  Objectifs techniques
Mettre en pratique les technologies suivantes :
- **HTML, CSS, JavaScript, PHP, SQL**
- **Git et GitHub** pour la gestion de versions
- **Node.js** pour relier le frontend et le backend??
---

##  Analyse des besoins

### 1. Utilisateurs du site
- **Visiteur** : consulter les albums
- **Client** : remplir un formulaire de commande
- **Administrateur** (optionnel) : ajout et modification des albums

---

### 2. Fonctionnalités attendues
- Affichage des albums
- Navigation claire entre les pages
- Formulaire de commande
- Calcul dynamique du prix
- Traitement du formulaire côté serveur

---

##  Arborescence du site

1. **Accueil**
   - Présentation du site
   - Albums mis en avant
2. **Catalogue**
   - Liste de tous les albums
3. **Albums Pop**
4. **Albums Rap**
5. **Albums R&B**
6. **Détail d’un album**
   - Image, artiste, prix, description
7. **Panier**
   - Récapitulatif des albums sélectionnés
8. **Commande**
   - Formulaire client
9. **Confirmation de commande**
   - Résumé et message de validation
10. **À propos**
11. **Contact**
12. **Favoris** (optionnel)

---

##  Conception graphique

Les maquettes du site ont été réalisées avec **Figma** pour les pages suivantes :
- Page d’accueil
- Catalogue
- Détail d’un album
- Formulaire de commande
- Page de connexion (optionnelle)

L’interface est pensée pour être **simple, lisible et responsive**.

---

##  Base de données

La base de données a été conçue afin de respecter les règles de modélisation (MCD / MLD).

- La **commande** est séparée des **albums** grâce à une table `ligne_commande`, ce qui permet de gérer **plusieurs albums et les quantités** dans une même commande.
- La fonctionnalité **favori** correspond à une relation **plusieurs-à-plusieurs** entre les clients et les albums.  
  Elle est modélisée à l’aide d’une **table associative `favori`**.

Cette structure garantit une base de données **cohérente, évolutive et conforme aux besoins du site e-commerce**.

---

## Programmation du site 



