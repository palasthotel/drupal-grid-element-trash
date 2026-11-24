# Grid Element Trash

A Drupal module for the [Grid](https://github.com/palasthotel/drupal-grid): puts boxes
and containers into a trash, so editors cannot add them in the grid editor anymore.
Elements that are already used in grids stay where they are; nothing is deleted or
changed.

The trash is set per content type. It covers

- box types (for example "html" or "node"),
- container types (content containers and sidebars),
- reusable boxes and reusable containers.

The lists of reusable boxes and containers get a "trash" link, and reusable elements
that are trashed for every content type disappear from those lists.

Requires Drupal 10.3 or 11, PHP 8.2 and the Drupal module
[palasthotel/drupal-grid](https://github.com/palasthotel/drupal-grid) 3.1 or later.

## Installation

The module is installed with Composer from GitHub, together with the Grid module and the
grid library. Add the repositories to the project's `composer.json`:

```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/palasthotel/drupal-grid-element-trash" },
    { "type": "vcs", "url": "https://github.com/palasthotel/drupal-grid" },
    { "type": "vcs", "url": "https://github.com/palasthotel/grid" }
]
```

and require the module:

```sh
composer require palasthotel/drupal-grid-element-trash
```

How the Grid module and the grid library are installed and built is described in the
[README of drupal-grid](https://github.com/palasthotel/drupal-grid#installation).

Then enable the module:

```sh
drush pm:install grid_element_trash
```

## Configuration

Everyone with the permission "administer grid" can use the trash.

- **Grid → Box Trash** (`/admin/config/grid/boxtrash`): per box type and per reusable
  box, the content types it is trashed for.
- **Grid → Container Trash** (`/admin/config/grid/containertrash`): the same for
  container types and reusable containers.
- **Put to trash** on the lists of reusable boxes and
  reusable containers: trashes the element for all content types after a confirmation.
  Bring it back on the box and container trash pages. This link needs drupal-grid 3.1.

The settings are stored in the config object `grid.trash`.

## Development

Pull requests are checked with `php -l` on PHP 8.2 to 8.4 and `composer validate`. See
[CONTRIBUTING.md](CONTRIBUTING.md) for commit messages and releases and
[SECURITY.md](SECURITY.md) for reporting vulnerabilities. Changes are listed in
[CHANGELOG.md](CHANGELOG.md).

## License

GPL-3.0-or-later, see [LICENSE](LICENSE).
