# Projet Symfony 7

## Introduction

Ce projet est une application de gestion de collections personnelles, permettant d'enregistrer et de suivre vos livres, mangas, romans, bandes dessinées, CD, DVD, et jeux vidéo. Vous pouvez facilement rechercher des éléments dans votre collection à l'aide d'un filtre, qui permet de trier par nom ou catégorie. De plus, l'application calcule et affiche le prix total de la collection filtrée, vous offrant une vue d'ensemble rapide de la valeur de vos biens.

## Prérequis

- **PHP 8.2 ou plus**
- **Composer** pour gérer les dépendances
  - *[Télécharger Composer](https://getcomposer.org/download/)*
- **Symfony Client** pour gérer le serveur de développement Symfony
  - *[Télécharger Symfony Client](https://symfony.com/download)*

*   composer create-project symfony/skeleton:"7.0.*" my_project_directory

*   cd my_project_directory
*   symfony server:start (N'oubliez pas d'initialiser le serveur à chaque session de travail)

## Installation

```bash
> composer require doctrine/annotations
```
```
> composer require symfony/form
```
```
> composer require --dev symfony/maker-bundle
```
```
> composer require doctrine/orm
```
```
> composer require orm
```
```
> php bin/console
```
## Résumé
Cette application Symfony vous permet de gérer et de cataloguer facilement vos collections de livres, CD, DVD, et autres médias. Grâce à une interface conviviale, vous pouvez filtrer vos éléments par nom ou catégorie, tout en ayant la possibilité de consulter le prix total de vos collections filtrées. C'est un outil idéal pour les collectionneurs désireux de garder une trace organisée de leurs biens.