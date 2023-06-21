# Création du projet


## création du projet symfony avec composer
composer create-project symfony/skeleton:"^5.4" my_project_directory 

## déplacement des fichiers à la racine
mv ./my_project_directory/* ./my_project_directory/.* .

## suppression du dossier temporaire
rmdir ./my_project_directory

## Installation du webapp
composer require webapp

## pour pouvoir utiliser @Route()
composer require annotations

## TWIG !
composer require twig

## formulaire ET validation
composer require form validator

## pour faire des liens correct dans twig vers nos assets
composer require symfony/asset

## vive le debug : la barre de debug avec le backoffice de debug : profiler
composer require --dev symfony/profiler-pack

## permet au dump de ne plus être dans la page, mais dans le WebDebugToolbar
composer require --dev symfony/debug-bundle

## le maker
composer require --dev symfony/maker-bundle

## Fixtures
composer require orm-fixtures --dev

## Faker
composer require fakerphp/faker

## installation du provider picsum
composer require --dev bluemmb/faker-picsum-photos-provider ^2.0

## Package sécurité CSRF
composer require security-csrf 

## Package SÉcurité
composer require symfony/security-bundle

## installation de tout les composants pour Doctrine
## A METTRE EN DERNIER car il nous pose une question à laquelle on répond 'x'
composer require symfony/orm-pack