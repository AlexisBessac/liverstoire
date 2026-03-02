# Entité `Events`

Ce document décrit l'entité `Events` située dans `src/Entity/Events.php`. Cette classe représente un événement historique dans l'application.

## Propriétés

| Nom        | Type PHP      | Base de données           | Contraintes de validation Symfony      | Description                                      |
|------------|---------------|---------------------------|-----------------------------------------|--------------------------------------------------|
| `id`       | `?int`        | `integer` (auto incrément)| N/A                                     | Identifiant unique de l'événement (clé primaire) |
| `chronos`  | `?string`     | `string`, longueur `100`  | `NotBlank`, `Length(2,100)`             | Date ou période de l'événement                   |
| `title`    | `?string`     | `string`, longueur `100`  | `NotBlank`, `Length(2,100)`             | Nom de l'événement                               |
| `content`  | `?string`     | `TEXT`, nullable          | `NotBlank`, `Length(2,1000)`            | Description détaillée de l'événement             |
| `periods`  | `?Periods`    | Relation ManyToOne        | N/A                                     | Période historique associée                      |

## Relations

- **ManyToOne** avec l'entité `Periods` (nom de propriété `$periods`) :
  un événement appartient à une seule période, mais une période peut contenir plusieurs événements.

## Utilisation en code

L'entité est générée et gérée par Doctrine ORM. Elle est également couplée aux validations via les annotations `Assert` de Symfony.

### Constructeurs & getters/setters

La classe propose des accesseurs (`get...`) et mutateurs (`set...`) pour chaque propriété. Les setters retournent `$this` pour permettre des appels chaînés.

```php
$event = new Events();
$event
    ->setChronos('1492')
    ->setTitle('Découverte de l\'Amérique')
    ->setContent('Christophe Colomb arrive aux Amériques.')
    ->setPeriods($somePeriod);
```

## Validation

Avant persistance, Symfony valide les propriétés :

- `chronos` et `title` ne doivent pas être vides et doivent avoir entre 2 et 100 caractères.
- `content` doit contenir entre 2 et 1000 caractères. Même si la colonne est nullable en base, la contrainte `NotBlank` force la présence d'un texte dans les formulaires/actions métiers.

## Migrations & base de données

Les changements dans l'entité sont synchronisés avec la base de données via les migrations Doctrine. Le projet contient déjà des fichiers de migration (`migrations/Version*.php`).

Pour générer une nouvelle migration après modification de l'entité :

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

## Remarques

- Le nom de la classe est `Events` (au pluriel). Cette convention peut être modifiée si besoin ; elle n'affecte pas le comportement de Doctrine.
- Les messages d'erreur de validation sont personnalisés pour fournir un retour à l'utilisateur en français.

---

Ce fichier sert de documentation rapide pour les développeurs travaillant sur l'application. Il peut être mis à jour en cas d'évolution de l'entité.

## Licence

Ce projet est distribué sous la licence **MIT**.

```
Copyright © 2026 Alexis Bessac

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```