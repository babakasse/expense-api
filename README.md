# Symfony Docker pour l'API de gestion de notes de frais

Ceci est une application basée sur le framework Symfony 6.2, en utilisant Docker pour faciliter le déploiement. J'ai réalisé le projet en suivant les spécifications du test technique, y compris toutes les tâches bonus (Authentification et tous les tests de points de terminaison).

![CI](https://github.com/dunglas/symfony-docker/workflows/CI/badge.svg)

## Environnement de développement et technologies utilisées

L'application a été développée en utilisant PHP 8.2 et PostgreSQL pour la gestion de la base de données. Pour l'authentification, j'ai utilisé le bundle LexikJWTAuthenticationBundle. Bien que l'implémentation complète de JWT pour les tests n'ait pas pu être réalisée, l'authentification fonctionne comme prévu.

J'ai également effectué des tests de tous les points de terminaison. Bien que l'implémentation actuelle soit pleinement fonctionnelle, des améliorations sont possibles. Par exemple, l'utilisation de types de formulaires pourrait alléger les contrôleurs et OpenAPI pourrait être utilisé pour la documentation de l'API. Des améliorations seront apportées en temps voulu.

## Caractéristiques

* Prêt pour la production, le développement et l'intégration continue
* HTTPS automatique (en dev et en prod!)
* Support de HTTP/2, HTTP/3 et [Preload](https://symfony.com/doc/current/web_link.html)
* Intégration native de [XDebug](docs/xdebug.md)
* Configuration très lisible

## Guide de démarrage

1. Si ce n'est pas déjà fait, [installez Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Exécutez `docker compose build --pull --no-cache` pour construire de nouvelles images
3. Exécutez `docker compose up` (les logs seront affichés dans la console actuelle)
4. Ouvrez `https://localhost` dans votre navigateur web préféré et [acceptez le certificat TLS auto-généré](https://stackoverflow.com/a/15076602/1352334)
5. Exécutez `docker compose down --remove-orphans` pour arrêter les conteneurs Docker.

## Licence

Symfony Docker est disponible sous la licence MIT.

## Crédits

Créé par [Kévin Dunglas](https://dunglas.fr), co-maintenu par [Maxime Helias](https://twitter.com/maxhelias) et sponsorisé par [Les-Tilleuls.coop](https://les-tilleuls.coop).
