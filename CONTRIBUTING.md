# Contributing to Bionic

Thanks for helping. Bug reports, fixes and new platform features are all welcome.

## Reporting bugs

Open an issue on the [issue tracker](https://github.com/mpaannddreew/bionic-php/issues). Include:

- your PHP version and Bionic version;
- the plugin (WhatsApp, Messenger, Instagram, Telegram or Viber);
- the webhook payload or request that misbehaves, with tokens, phone numbers and other personal data removed;
- what you expected to happen and what happened instead.

Report security issues privately to the maintainer, not in a public issue.

## Development setup

You need PHP 8.2 or later and Composer.

```bash
git clone https://github.com/mpaannddreew/bionic-php.git
cd bionic-php
composer install
```

## Checks

CI runs three checks on every push and pull request. Run them before you open a pull request:

```bash
composer test      # PHPUnit
composer analyse   # PHPStan, level 5
composer lint      # PHP-CS-Fixer in dry-run mode (PSR-12)
```

`composer lint:fix` applies the formatting fixes.

## Tests

- Tests live in `tests/`, with JSON fixtures in `tests/fixtures/<platform>/`.
- Base webhook fixtures on the platform's documented payloads. Don't use captured real traffic, which contains
  personal data.
- Tests must not make network calls. Use the `mockHttp()` helper in `tests/TestCase.php`: it puts a Guzzle
  `MockHandler` behind the plugin and records each request, so you can assert the URL, headers and JSON body.
- `receive()` in the same class runs a payload through a plugin and records every event it emits.

## Pull requests

- Keep the public API backwards compatible. Add new methods and events rather than changing existing signatures or
  event parameters. If a breaking change is unavoidable, explain it in the pull request.
- Follow the existing patterns. For example, a new WhatsApp message type is a class in
  `src/Plugins/WhatsApp/Messages/` that extends `AbstractMessage`.
- Add or update tests, document new events and methods in the README, and add an entry under `[Unreleased]` in
  `CHANGELOG.md`.
- Make one logical change per commit, with a message that says what changed and why.
