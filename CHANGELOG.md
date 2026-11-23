# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- WhatsApp template messages: `Messages\Template`, with `Template::named($name, $languageCode, $components)`.
- WhatsApp interactive messages: `Messages\Interactive`, with `Interactive::buttons()` for reply buttons and
  `Interactive::list()` for lists.
- WhatsApp webhook events:
  - `message.video`;
  - `message.interactive` (button and list replies);
  - `message.button` (template quick-reply taps);
  - `status.sent`, `status.delivered`, `status.read` and `status.failed`, fired alongside `status`.
- `WhatsAppPlugin::retrieveMedia($mediaId, $phoneNumberId = null)`, which returns the decoded media object.
- `WhatsAppPlugin::downloadMedia($mediaUrl, $sink = null)`, which downloads a media file with the access token.
- Getters for fields Meta has added to webhook payloads:
  - `Message::getFromUserId()`, `Message::getInteractive()`, `Message::getButton()`;
  - `Contact::getUserId()`, `Profile::getUsername()`;
  - `Status::getRecipientUserId()`, `getErrors()`, `getConversation()`, `getPricing()`, `getBizOpaqueCallbackData()`;
  - `getUrl()` on media and stickers, `Sticker::isAnimated()`;
  - `Error::getMessage()`, `Error::getErrorData()`.
- `AbstractBionicPlugin::setHttpClient()` to supply your own Guzzle client (timeouts, proxies, CA bundle, test mocks).
- A PHPUnit test suite with Meta's documented webhook payloads as fixtures, PHPStan (level 5), PHP-CS-Fixer (PSR-12),
  the Composer scripts `test`, `analyse` and `lint`, and GitHub Actions CI on PHP 8.2 to 8.5 (8.6 experimental).
- `CONTRIBUTING.md` and this changelog.

### Changed

- **Graph API v27.0 is now the default** for WhatsApp (was v13.0) and Messenger (was v9.0). Set `graph_api_version`
  or call `setGraphApiVersion()` to pin a different version.
- **TLS certificates are now verified** on every request. All plugins had disabled verification (`'verify' => false`).
  If your server lacks a CA bundle, install one or pass a configured client to `setHttpClient()`.
- **Requires PHP 8.2 or later** and `ext-json`. Earlier releases declared no PHP constraint; Guzzle 7.2 needed
  PHP 7.2.5 or later. Guzzle 7.15.2 is now the minimum, which fixes the security advisories in older Guzzle releases.
- `Error::getDetails()` falls back to `error_data.details`, which is where current Graph API versions put the details.
- Source files carry a standard license header instead of PhpStorm's generated header, and are formatted to PSR-12.
- The README documents WhatsApp in full and has a table of contents.

### Fixed

- The WhatsApp `errors` and `error` events never fired, and `WhatsAppValue::getErrors()` was always empty.
- Messenger: an attachment of an unknown type added `null` (or a copy of the previous attachment) to
  `getAttachmentItems()`. Unknown types are now skipped.
- PHP 8.4 deprecation: Messenger `setProperties()` declared an implicitly nullable parameter.
- PHP 8 deprecation: Messenger `sendPlainText()` and `sendText()` declared an optional parameter before a required one.
  The `[]` default had no effect, so calls are unchanged.
- Wrong or invalid docblock types throughout. Nullable getters are now documented as nullable, and
  `retrieveMediaURL()` is documented as returning the HTTP response.

## [2.1.9] and earlier

See the [tags on GitHub](https://github.com/mpaannddreew/bionic-php/tags).

[Unreleased]: https://github.com/mpaannddreew/bionic-php/compare/v2.1.9...HEAD
[2.1.9]: https://github.com/mpaannddreew/bionic-php/releases/tag/v2.1.9
