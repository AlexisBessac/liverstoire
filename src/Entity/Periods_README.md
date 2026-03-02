# Entité `Periods`

Ce document décrit l'entité `Periods` située dans `src/Entity/Periods.php`. Cette classe représente une période historique à laquelle peuvent être rattachés plusieurs événements.

## Propriétés

| Nom      | Type PHP      | Base de données            | Contraintes de validation Symfony        | Description                                   |
|----------|---------------|----------------------------|------------------------------------------|-----------------------------------------------|
| `id`     | `?int`        | `integer` (auto incrément) | N/A                                      | Identifiant unique de la période              |
| `name`   | `?string`     | `string`, longueur `50`    | `NotBlank`, `Length(2,50)`               | Nom de la période historique                  |
| `color`  | `?string`     | `string`, longueur `7`     | `NotBlank`, `Regex` `^#[0-9A-Fa-f]{6}$`  | Code couleur hexadécimal associé              |

## Relations

- **OneToMany** vers l'entité `Events` :
  une période peut regrouper plusieurs événements (`$events`).
  À l'inverse, chaque `Events` possède une propriété `periods` (ManyToOne) indiquant sa période.

## Utilisation en code

L'entité utilise Doctrine ORM et est gérée via le repository `PeriodsRepository`.
Elle expose des accesseurs et mutateurs pour chaque propriété, ainsi que des méthodes pour gérer la collection d'événements :

```php
$period = new Periods();
$period
    ->setName('Moyen Âge')
    ->setColor('#8A2BE2');

// ajout d'un event existant
$period->addEvent($event);

// suppression
$period->removeEvent($event);
```

La collection `$events` est initialisée dans le constructeur avec une `ArrayCollection`.

## Validation

- `name` doit être renseigné et compter entre 2 et 50 caractères.
- `color` doit être un code hexadécimal valide de la forme `#RRGGBB` (regex appliquée).

## Migrations & base de données

Comme pour les autres entités, les modifications doivent être propagées avec :

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

## Remarques

- Les périodes sont identifiées par un nom et une couleur, souvent utiles pour l'affichage graphiquement différencié.
- Les méthodes `addEvent` et `removeEvent` maintiennent la cohérence de la relation bidirectionnelle.

---

Ce fichier informe rapidement les développeurs et peut être prolongé si l'entité évolue.

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