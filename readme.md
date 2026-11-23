# Bionic

[![CI](https://github.com/mpaannddreew/bionic-php/actions/workflows/ci.yml/badge.svg)](https://github.com/mpaannddreew/bionic-php/actions/workflows/ci.yml)
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

Bionic is an event-driven PHP library for chatbots and messaging integrations. Give it a webhook payload and it parses
the payload into objects and emits an event for each thing that happened: a text message, an image, a button tap, a
delivery receipt. Each platform plugin also has methods for sending messages back.

Supported platforms:

* **WhatsApp (Cloud API):** text, media, location and contact messages; template and interactive (button and list)
  messages; read receipts; media download; delivery statuses and errors
* Facebook Messenger
* Instagram
* Telegram
* Viber

Bionic is built on [Événement](https://github.com/igorw/evenement) for events and [Guzzle](https://github.com/guzzle/guzzle)
for HTTP.

**Requirements:** PHP 8.2 or later with the `json` extension. Composer installs the other dependencies.

## Contents

* [Installation](#installation)
* [Getting started](#getting-started)
* [Usage with WhatsApp](#usage-with-whatsapp)
  * [Prerequisites](#prerequisites)
  * [Creating the plugin and the Bionic instance](#creating-the-plugin-and-the-bionic-instance)
  * [Verifying the webhook](#verifying-the-webhook)
  * [Handling incoming webhooks](#handling-incoming-webhooks)
  * [WhatsApp events](#whatsapp-events)
  * [Sending text and media](#sending-text-and-media)
  * [Template messages](#template-messages)
  * [Interactive messages](#interactive-messages)
  * [Marking messages as read](#marking-messages-as-read)
  * [Downloading media](#downloading-media)
  * [Graph API version and HTTP client](#graph-api-version-and-http-client)
* [Usage with Messenger and Instagram](#usage-with-messenger-and-instagram)
* [Usage with Telegram](#usage-with-telegram)
* [Usage with Viber](#usage-with-viber)
* [Exception handling](#exception-handling)
* [Contributing](#contributing)
* [Changelog](#changelog)
* [Bugs](#bugs)

## Installation

Install Bionic [with Composer](https://getcomposer.org):

```bash
composer require andre/bionic
```

Then include Composer's autoloader:

```php
<?php
require 'vendor/autoload.php';
```

## Getting started

### Creating a Bionic instance

```php
<?php
use Andre\Bionic\Bionic;

$bionic = Bionic::initialize();
```
### Registering event listeners
#### Syntax

```php
<?php
$bionic->listen($event_name, $event_listener);
```
#### With an anonymous function

```php
<?php
$bionic->listen($event_name, function($required_parameters_depending_on_event_name){});
```
#### With a defined function

```php
<?php
function function_name($required_parameters_depending_on_event_name){}

$bionic->listen($event_name, 'function_name');
```
#### With a class method

```php
<?php
class BotController{
    public function function_name($required_parameters_depending_on_event_name){}
}

$controller = new BotController();
$bionic->listen($event_name, [$controller, 'function_name']);
```

#### With a static class method

```php
<?php
class BotController{
    public static function function_name($required_parameters_depending_on_event_name){}
}

$bionic->listen($event_name, [BotController::class, 'function_name']);
```

## Usage with WhatsApp

The WhatsApp plugin works with the [WhatsApp Business Platform Cloud API](https://developers.facebook.com/documentation/business-messaging/whatsapp/overview).
Meta sends events to your webhook. You pass each payload to Bionic and send replies through the plugin.

### Prerequisites

* A Meta developer app with the **WhatsApp** product added, and a WhatsApp Business Account.
* The **phone number ID** of the business phone number you send from. It is shown in the app's WhatsApp > API Setup page.
* An **access token** with the `whatsapp_business_messaging` permission. The API Setup page gives you a temporary
  token for testing. In production, use a system user token.
* A public **HTTPS URL** for your webhook. Subscribe it to the `messages` webhook field.
* A **verify token**: any string you choose and enter in the webhook settings.
* Your app's **app secret** (App settings > Basic), to check webhook signatures.

### Creating the plugin and the Bionic instance

```php
<?php
use Andre\Bionic\Bionic;
use Andre\Bionic\Plugins\WhatsApp\WhatsAppPlugin;

$plugin = WhatsAppPlugin::create([
    'phone_number_id' => 'your phone number id',
    'access_token' => 'your access token',
    // 'graph_api_version' => 'v27.0', // optional, defaults to v27.0
]);

$bionic = Bionic::initialize()->setPlugin($plugin);
```

The setters `setPhoneNumberId()`, `setAccessToken()` and `setGraphApiVersion()` change these values later.

### Verifying the webhook

When you save the webhook URL, Meta sends a `GET` request with `hub.mode`, `hub.verify_token` and `hub.challenge`.
Reply with the challenge if the token matches. PHP turns the dots in query parameter names into underscores:

```php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $mode = $_GET['hub_mode'] ?? null;
    $token = $_GET['hub_verify_token'] ?? null;

    if ($mode === 'subscribe' && hash_equals('your verify token', (string) $token)) {
        echo $_GET['hub_challenge'];
        http_response_code(200);
    } else {
        http_response_code(403);
    }

    exit;
}
```

Meta signs every event it sends with your app secret, in the `X-Hub-Signature-256` header. Check the signature
before you trust the payload:

```php
<?php
$payload = file_get_contents('php://input');
$expected = 'sha256=' . hash_hmac('sha256', $payload, 'your app secret');

if (!hash_equals($expected, $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '')) {
    http_response_code(403);
    exit;
}
```

### Handling incoming webhooks

Register listeners, then pass the decoded payload to `receive()`. Answer with `200` quickly. Meta retries events that
aren't acknowledged.

```php
<?php
use Andre\Bionic\Plugins\WhatsApp\Contacts\Contact;
use Andre\Bionic\Plugins\WhatsApp\Error;
use Andre\Bionic\Plugins\WhatsApp\Message;
use Andre\Bionic\Plugins\WhatsApp\Messages\Image;
use Andre\Bionic\Plugins\WhatsApp\Messages\Location;
use Andre\Bionic\Plugins\WhatsApp\Messages\Text;
use Andre\Bionic\Plugins\WhatsApp\MetaData;
use Andre\Bionic\Plugins\WhatsApp\Status;
use Andre\Bionic\Plugins\WhatsApp\WhatsAppPlugin;

$bionic->listen('message.text', function (WhatsAppPlugin $plugin, MetaData $meta, array $contacts, Message $message, Text $text) {
    /** @var Contact $contact */
    $contact = $contacts[0];
    $name = $contact->getProfile()->getName();

    $plugin->sendMessage('text', Text::create(['body' => "Hi $name, you said: " . $text->getBody()]), $message->getFrom());
});

$bionic->listen('message.image', function (WhatsAppPlugin $plugin, MetaData $meta, array $contacts, Message $message, Image $image) {
    $image->getId();       // media ID, for retrieveMedia()
    $image->getCaption();
    $image->getMimeType();
});

$bionic->listen('message.location', function (WhatsAppPlugin $plugin, MetaData $meta, array $contacts, Message $message, Location $location) {
    $location->getLatitude();
    $location->getLongitude();
    $location->getName();
    $location->getAddress();
});

$bionic->listen('message.contacts', function (WhatsAppPlugin $plugin, MetaData $meta, array $contacts, Message $message, array $sharedContacts) {
    // $sharedContacts are the contact cards the user shared, as arrays:
    $sharedContacts[0]['name']['formatted_name'];
    $sharedContacts[0]['phones'][0]['phone'];
});

$bionic->listen('status.delivered', function (WhatsAppPlugin $plugin, MetaData $meta, Status $status) {
    $status->getId();          // the ID of the message you sent
    $status->getRecipientId();
    $status->getTimestamp();
});

$bionic->listen('status.failed', function (WhatsAppPlugin $plugin, MetaData $meta, Status $status) {
    foreach ($status->getErrors() as $error) {
        $error->getCode();
        $error->getTitle();
        $error->getDetails();
    }
});

$bionic->listen('error', function (WhatsAppPlugin $plugin, MetaData $meta, Error $error) {
    // app-, account- or system-level errors not tied to one message
});

$bionic->listen('exception', function (\Exception $exception) {
    error_log($exception->getMessage());
});

$bionic->receive(json_decode($payload, true));
http_response_code(200);
```

`$contacts` holds the sender's profile: `Contact::getWaId()`, `getUserId()` and `getProfile()->getName()`.
`MetaData` holds the business number: `getDisplayPhoneNumber()` and `getPhoneNumberId()`.

### WhatsApp events

Every listener receives the plugin first. The parameters after it depend on the event:

| Event | Parameters after `$plugin` | Fired for |
| --- | --- | --- |
| `entry` | `array $entryItems` | every payload |
| `entry.item` | `EntryItem $entryItem` | each entry |
| `changes` | `array $changes` | each entry with changes |
| `change` | `Change $change` | each change |
| `change.value` | `Change $change, WhatsAppValue $value` | each change value |
| `messages` | `MetaData $meta, array $contacts, array $messages` | incoming messages |
| `message` | `MetaData $meta, array $contacts, Message $message` | each incoming message |
| `message.text` | `..., Message $message, Text $text` | text messages |
| `message.image` | `..., Message $message, Image $image` | images |
| `message.video` | `..., Message $message, Video $video` | videos |
| `message.voice` | `..., Message $message, Audio $audio` | audio, including voice notes (`$audio->isVoice()`) |
| `message.document` | `..., Message $message, Document $document` | documents |
| `message.sticker` | `..., Message $message, Sticker $sticker` | stickers |
| `message.location` | `..., Message $message, Location $location` | locations |
| `message.contacts` | `..., Message $message, array $sharedContacts` | shared contact cards |
| `message.interactive` | `..., Message $message, Interactive $interactive` | replies to button and list messages |
| `message.button` | `..., Message $message, Button $button` | taps on a template's quick-reply button |
| `message.system` | `..., Message $message, System $system` | system messages, e.g. the user changed number |
| `message.errors` | `..., Message $message, array $errors` | messages WhatsApp couldn't deliver to you (type `unsupported`) |
| `statuses` | `MetaData $meta, array $statuses` | status updates |
| `status` | `MetaData $meta, Status $status` | each status |
| `status.sent`, `status.delivered`, `status.read`, `status.failed` | `MetaData $meta, Status $status` | each status, by its value |
| `errors` | `MetaData $meta, array $errors` | app-, account- or system-level errors |
| `error` | `MetaData $meta, Error $error` | each of those errors |
| `exception` | `\Exception $exception` (no `$plugin`) | an exception thrown while handling the payload, including from your listeners |

`...` stands for `MetaData $meta, array $contacts`. The classes are in `Andre\Bionic\Plugins\WhatsApp` (`Message`,
`MetaData`, `Status`, `Error`, `WhatsAppValue`), `Andre\Bionic\Plugins\WhatsApp\Messages` (`Text`, `Image`, `Video`,
`Audio`, `Document`, `Sticker`, `Location`, `Interactive`, `Button`, `System`) and
`Andre\Bionic\Plugins\Messenger\Messages` (`EntryItem`, `Change`).

A `Status` also has `getRecipientUserId()`, `getConversation()` and `getPricing()` when Meta includes those fields.
`Message::getContext()` returns the message being replied to.

### Sending text and media

`sendMessage($type, $message, $to)` sends a message to a phone number and returns a `WhatsAppValue`:

```php
<?php
use Andre\Bionic\Plugins\WhatsApp\Messages\Text;

$value = $plugin->sendMessage('text', Text::create([
    'body' => 'Your order has shipped: https://example.com/track/123',
    'preview_url' => true,
]), '+16505551234');

$value->getMessages()[0]->getId(); // wamid... of the sent message
$value->getContacts()[0]->getWaId();
```

Media messages take a public `link` or the `id` of media you uploaded to WhatsApp:

```php
<?php
use Andre\Bionic\Plugins\WhatsApp\Messages\Audio;
use Andre\Bionic\Plugins\WhatsApp\Messages\Document;
use Andre\Bionic\Plugins\WhatsApp\Messages\Image;
use Andre\Bionic\Plugins\WhatsApp\Messages\Sticker;
use Andre\Bionic\Plugins\WhatsApp\Messages\Video;

$plugin->sendMessage('image', Image::create(['link' => 'https://example.com/photo.jpg', 'caption' => 'Our new store']), $to);
$plugin->sendMessage('video', Video::create(['id' => '1166846181421424', 'caption' => 'How it works']), $to);
$plugin->sendMessage('audio', Audio::create(['link' => 'https://example.com/greeting.mp3']), $to);
$plugin->sendMessage('document', Document::create(['link' => 'https://example.com/invoice.pdf', 'filename' => 'invoice.pdf']), $to);
$plugin->sendMessage('sticker', Sticker::create(['id' => '798882015472548']), $to);
```

You can also pass the whole request body yourself with `send()`. Bionic adds `messaging_product` and `recipient_type`:

```php
<?php
$plugin->send([
    'to' => '+16505551234',
    'type' => 'reaction',
    'reaction' => ['message_id' => 'wamid.HBgL...', 'emoji' => '👍'],
]);
```

### Template messages

To message someone outside the 24-hour customer service window, use a template that Meta has approved:

```php
<?php
use Andre\Bionic\Plugins\WhatsApp\Messages\Template;

$plugin->sendMessage('template', Template::named('hello_world', 'en_US'), '+16505551234');

// With parameters
$plugin->sendMessage('template', Template::named('order_confirmation', 'en_US', [
    [
        'type' => 'body',
        'parameters' => [
            ['type' => 'text', 'parameter_name' => 'first_name', 'text' => 'Jessica'],
            ['type' => 'text', 'parameter_name' => 'order_number', 'text' => 'SKBUP2-4CPIG9'],
        ],
    ],
]), '+16505551234');
```

`Template::create([...])` takes the full `template` object if you'd rather build it yourself. When someone taps one of a
template's quick-reply buttons, the `message.button` event fires with a `Button` (`getPayload()`, `getText()`).

### Interactive messages

Reply buttons (up to three) and lists:

```php
<?php
use Andre\Bionic\Plugins\WhatsApp\Messages\Interactive;

$plugin->sendMessage('interactive', Interactive::buttons(
    'Your appointment is at 9am tomorrow. Need to change it?',
    ['change-button' => 'Change', 'cancel-button' => 'Cancel'], // id => title
    ['type' => 'text', 'text' => 'Appointment reminder'],        // optional header
    'Lucky Shrub'                                                 // optional footer
), '+16505551234');

$plugin->sendMessage('interactive', Interactive::list(
    'Which shipping option do you prefer?',
    'Shipping options', // the button that opens the list
    [
        [
            'title' => 'I want it ASAP!',
            'rows' => [
                ['id' => 'priority_express', 'title' => 'Priority Mail Express', 'description' => 'Next day to 2 days'],
                ['id' => 'priority_mail', 'title' => 'Priority Mail', 'description' => '1-3 days'],
            ],
        ],
    ]
), '+16505551234');
```

`Interactive::create([...])` takes the full `interactive` object, for headers with media or other interactive types.
Replies arrive as `message.interactive`:

```php
<?php
use Andre\Bionic\Plugins\WhatsApp\Message;
use Andre\Bionic\Plugins\WhatsApp\MetaData;
use Andre\Bionic\Plugins\WhatsApp\Messages\Interactive;
use Andre\Bionic\Plugins\WhatsApp\WhatsAppPlugin;

$bionic->listen('message.interactive', function (WhatsAppPlugin $plugin, MetaData $meta, array $contacts, Message $message, Interactive $reply) {
    $reply->getType();       // "button_reply" or "list_reply"
    $reply->getReplyId();    // e.g. "cancel-button" or "priority_express"
    $reply->getReplyTitle();
});
```

### Marking messages as read

```php
<?php
$bionic->listen('message', function (WhatsAppPlugin $plugin, MetaData $meta, array $contacts, Message $message) {
    $plugin->markRead($message->getId());
});
```

`markRead()` returns the HTTP response. Its body is `{"success": true}`.

### Downloading media

Incoming media gives you a media ID. `retrieveMedia()` turns the ID into a URL that is valid for 5 minutes.
`downloadMedia()` then fetches the file with your access token:

```php
<?php
$bionic->listen('message.image', function (WhatsAppPlugin $plugin, MetaData $meta, array $contacts, Message $message, Image $image) {
    $media = $plugin->retrieveMedia($image->getId());
    // ['messaging_product' => 'whatsapp', 'url' => ..., 'mime_type' => ..., 'sha256' => ..., 'file_size' => ..., 'id' => ...]

    $bytes = $plugin->downloadMedia($media['url']);

    // or stream it straight to a file
    $plugin->downloadMedia($media['url'], '/path/to/uploads/' . $image->getId() . '.jpg');
});
```

Recent webhook payloads also include the media URL. Media classes expose it as `getUrl()`, but it expires after 5
minutes. Media IDs from webhooks can be downloaded for 7 days. `retrieveMediaURL()` still returns the raw HTTP
response for the same request as `retrieveMedia()`.

### Graph API version and HTTP client

The plugin uses Graph API **v27.0** by default. To pin another version, use the `graph_api_version` config key or
`$plugin->setGraphApiVersion('v26.0')`.

To set timeouts or a proxy, or to use a mock handler in tests, pass your own Guzzle client:

```php
<?php
$plugin->setHttpClient(new \GuzzleHttp\Client([
    'timeout' => 10,
    'headers' => ['Content-Type' => 'application/json'],
]));
```

## Usage with Messenger and Instagram

### Setup

* Create a FB Page
* Create a FB app
* Create a webhook
* Connect the Facebook app to the Facebook page
* Install Bionic (see [Installation](#installation))

#### Create a FB page

First login to Facebook and [create a Facebook page](https://www.facebook.com/pages/create). Choose the settings that 
fits best your bot, but for testing it is not important.

#### Create a FB Messenger app

Go to the [developer's app page](https://developers.facebook.com/apps/). Click "Add a New App" and
 fill the basic app fields.

On the "Product Setup" page choose Messenger and click "Get Started".

Now you need to create a token to give your app access to your Facebook page. Select the created page, grant permissions 
and copy the generated token. You need that one later.

#### Create a webhook for the Facebook app for either Messenger or Instagram

Your application needs to have a webhook. This means a public URL that Facebook can communicate with. Every time a user 
sends a message inside the FB chat, FB will send it to this URL which is the entry point to your application.

#### Connect the Facebook app to your application

Now that you got the URL you need to setup the webhook. Go back to you Facebook app settings and click `Setup Webhooks` 
inside the Webhooks part.

Fill in the public URL, check the subscription fields you want to with and click `Verify and Save`.

***Note:*** You need to write your own webhook verification logic in your application.

### Example

```php
<?php
use Andre\Bionic\Bionic;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Nlp;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;
use Andre\Bionic\Plugins\Messenger\Messages\Message\ReplyTo;
use Andre\Bionic\Plugins\Messenger\Messages\Referral;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Text;
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

/* validate verify token needed for setting up web hook */
if (isset($_GET['hub_verify_token'])) {
    if ($_GET['hub_verify_token'] === 'your verify token') {
        echo $_GET['hub_challenge'];
        return;
    } else {
        echo 'Invalid Verify Token';
        return;
    }
}

$data = json_decode(file_get_contents('php://input'), true);

$config = [
    'page_access_token' => 'your page access token',
    // 'graph_api_version' => 'v27.0' optional and defaults to v27.0
];

// This applies for only instagram and messenger where you need to specify the object type as the events prefix
$object_type = "page"; // page or instagram

$bionic = Bionic::initialize()
    ->setPlugin(Plugin::create($config))
    ->setEventPrefix($object_type);

// register your event listeners before calling the 'receive' method on the bionic instance
// $bionic->listen($event_name, $event_listener);
$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Image $image, $channel){
    // $plugin - current plugin being used i.e. MessengerPlugin
    // $sender - sender of the message i.e. Messenger user
    // $recipient - recipient of the message i.e. Your facebook page
    // $message - current message object
    // $image - Image attachment that was sent
    // $channel - event delivery channel, messaging or standby
   
    // this sends the attachment as a message back to the sender
    $plugin->sendAttachment($image, $sender);
})->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Text $text, ?QuickReply $quickReply, ?ReplyTo $replyTo, ?Referral $referral, ?Nlp $nlp, $channel) {
      $text->getText();
      if ($quickReply)
          $quickReply->getPayload();
  
      if ($nlp)
          $nlp->getEntities();
  
      $plugin->sendText($text, [], $sender);
})->listen('exception', function (Exception $exception) {
      
});

$bionic->receive($data);
return http_response_code(200);
```
### Basic example

```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Image $image, $channel){  
    // this sends back the attachment as a message back to the sender
    $plugin->sendAttachment($image, $sender);
});
```

### Available events provided for messenger and Instagram
#### Some events do not apply for Instagram, consult [documentation](https://developers.facebook.com/docs/messenger-platform/instagram)

- entry
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;

$bionic->listen('entry', function (Plugin $plugin, $entryItems){
    
     /**
     * @var \Andre\Bionic\Plugins\Messenger\Messages\EntryItem $entryItem
     * @var \Andre\Bionic\Plugins\Messenger\Messages\MessagingItem $messagingItem
     */
     
     // $entryItems is an array of Andre\Bionic\Plugins\Messenger\Messages\EntryItem::class
     foreach ($entryItems as $entryItem){
         foreach ($entryItem->getMessagingItems() as $messagingItem){
             $messagingItem->getMessage();
             $messagingItem->getPostback();
             $messagingItem->getAccountLinking();
             $messagingItem->getReferral();
             $messagingItem->getRead();
             $messagingItem->getDelivery();
             $messagingItem->getOptin();
             $messagingItem->getSender();
             $messagingItem->getRecipient();
             $messagingItem->getTimestamp();
             $messagingItem->getCheckoutUpdate();
             $messagingItem->getAppRoles();
             $messagingItem->getPassThreadControl();
             $messagingItem->getTakeThreadControl();
             $messagingItem->getPreCheckout();
             $messagingItem->getPayment();
         }
     }
});
```
- entry.item
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EntryItem;

$bionic->listen('entry.item', function (Plugin $plugin, EntryItem $entryItem){
    /**
     * @var \Andre\Bionic\Plugins\Messenger\Messages\EntryItem $entryItem
     * @var \Andre\Bionic\Plugins\Messenger\Messages\MessagingItem $messagingItem
     */
    foreach ($entryItem->getMessagingItems() as $messagingItem){
         $messagingItem->getMessage();
         $messagingItem->getPostback();
         $messagingItem->getAccountLinking();
         $messagingItem->getReferral();
         $messagingItem->getRead();
         $messagingItem->getDelivery();
         $messagingItem->getOptin();
         $messagingItem->getSender();
         $messagingItem->getRecipient();
         $messagingItem->getTimestamp();
         $messagingItem->getCheckoutUpdate();
         $messagingItem->getAppRoles();
         $messagingItem->getPassThreadControl();
         $messagingItem->getTakeThreadControl();
         $messagingItem->getPreCheckout();
         $messagingItem->getPayment();
    }
});
```
- messaging
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;

$bionic->listen('messaging', function (Plugin $plugin, $messagingItems){
    /**
     * @var \Andre\Bionic\Plugins\Messenger\Messages\MessagingItem $messagingItem
     */
    
     // $messagingItems is an array of Andre\Bionic\Plugins\Messenger\Messages\MessagingItem::class
     foreach ($messagingItems as $messagingItem){
          $messagingItem->getMessage();
          $messagingItem->getPostback();
          $messagingItem->getAccountLinking();
          $messagingItem->getReferral();
          $messagingItem->getRead();
          $messagingItem->getDelivery();
          $messagingItem->getOptin();
          $messagingItem->getSender();
          $messagingItem->getRecipient();
          $messagingItem->getTimestamp();
          $messagingItem->getCheckoutUpdate();
          $messagingItem->getAppRoles();
          $messagingItem->getPassThreadControl();
          $messagingItem->getTakeThreadControl();
          $messagingItem->getPreCheckout();
          $messagingItem->getPayment();
     }
});
```
- standby
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;

$bionic->listen('standby', function (Plugin $plugin, $standbyItems){
    /**
     * @var \Andre\Bionic\Plugins\Messenger\Messages\StandbyItem $standbyItem
     */
    
     // $messagingItems is an array of Andre\Bionic\Plugins\Messenger\Messages\$standbyItems::class
     foreach ($standbyItems as $standbyItem){
          $standbyItem->getMessage();
          $standbyItem->getRead();
          $standbyItem->getDelivery();
     }
});
```
- messaging.item
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\MessagingItem;

$bionic->listen('messaging.item', function (Plugin $plugin, MessagingItem $messagingItem){
    /**
     * @var \Andre\Bionic\Plugins\Messenger\Messages\MessagingItem $messagingItem
     */
    
    $messagingItem->getMessage();
    $messagingItem->getPostback();
    $messagingItem->getAccountLinking();
    $messagingItem->getReferral();
    $messagingItem->getRead();
    $messagingItem->getDelivery();
    $messagingItem->getOptin();
    $messagingItem->getSender();
    $messagingItem->getRecipient();
    $messagingItem->getTimestamp();
    $messagingItem->getCheckoutUpdate();
    $messagingItem->getAppRoles();
    $messagingItem->getPassThreadControl();
    $messagingItem->getTakeThreadControl();
    $messagingItem->getPreCheckout();
    $messagingItem->getPayment();
});
```
- standby.item
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\StandbyItem;

$bionic->listen('standby.item', function (Plugin $plugin, StandbyItem $standbyItem){
    $standbyItem->getMessage();
    $standbyItem->getRead();
    $standbyItem->getDelivery();
});
```
- message
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, $channel){
    // $message - represents message sent to your page
    $message->getText();
    $message->getNlp();
    $message->getQuickReply();
    $message->getAppId();
    $message->getAttachmentItems();
    $message->getMetadata();
    $message->getMid();
    $message->getSeq();
    $message->isEcho(); // false
});
```

- message.echo
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.echo', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message){
    // $message - represents message sent by your page
    $message->getText();
    $message->getQuickReply();
    $message->getAppId();
    $message->getAttachmentItems();
    $message->getMetadata();
    $message->getMid();
    $message->getSeq();
    $message->isEcho(); // true
});
```
- message.text
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;
use Andre\Bionic\Plugins\Messenger\Messages\Message\ReplyTo;
use Andre\Bionic\Plugins\Messenger\Messages\Referral;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Nlp;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Text $text, ?QuickReply $quickReply, ?ReplyTo $replyTo, ?Referral $referral, ?Nlp $nlp, $channel){
    $text->getText();
    if ($quickReply)
        $quickReply->getPayload();
    
    if ($nlp)
        $nlp->getEntities();
    
    $plugin->sendPlainText($text->getText(), [], $sender);
    $plugin->sendText($text, [], $sender);
});
```
- message.attachments
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, $messageAttachments, $channel){
    // $messageAttachments - an array of attachments e.g. Image, Audio, Location, Video, Fallback
    foreach ($messageAttachments as $attachment){
        $attachment->getType();
        $plugin->sendAttachment($attachment, $sender);
    }
});
```
- message.attachments.image
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Image $image, $channel){
    $image->getPayload()->getUrl();
    $plugin->sendAttachment($image, $sender);
});
```
- message.attachments.audio
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Audio;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.audio', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Audio $audio, $channel){
    $audio->getPayload()->getUrl();
    
    // Sending audio is only supported on messenger
    $plugin->sendAttachment($audio, $sender);
});
```
- message.attachments.video
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Video;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.video', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Video $video, $channel){
    $video->getPayload()->getUrl();
    
    // Sending videos is only supported on messenger
    $plugin->sendAttachment($video, $sender);
});
```
- message.attachments.location
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Location;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.location', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Location $location, $channel){
    $coordinates = $location->getPayload()->getCoordinates();
    $coordinates->getLat();
    $coordinates->getLong();
});
```
- message.attachments.file
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\File;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.file', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, File $file, $channel){
    $file->getPayload()->getUrl();
    $plugin->sendAttachment($file, $sender);
});
```
- message.attachments.fallback
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Fallback;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.fallback', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Fallback $fallback, $channel){
    $fallback->getTitle();
    $fallback->getURL();
});
```
- postback
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\PostBack;

$bionic->listen('postback', function (Plugin $plugin, Sender $sender, Recipient $recipient, PostBack $postBack){
    $postBack->getPayload();
});
```
- referral
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Referral;

$bionic->listen('referral', function (Plugin $plugin, Sender $sender, Recipient $recipient, Referral $referral){
    $referral->getType();
    $referral->getSource();
});
```
- optin
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Optin;

$bionic->listen('optin', function (Plugin $plugin, Sender $sender = null, Recipient $recipient, Optin $optin){
    $optin->getRef();
    
    // if using Checkbox Plugin and set user_ref
    if ($optin->getUserRef()){
        $response = $plugin->sendPlainText("Hello, thank you for opting in.", [], Recipient::create(['user_ref' => $optin->getUserRef()]));
        $response->getBody()->getContents(); // information about the response
    }
});
```
- account_linking
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\AccountLinking;

$bionic->listen('account_linking', function (Plugin $plugin, Sender $sender, Recipient $recipient, AccountLinking $accountLinking){
    $status = $accountLinking->getStatus();
    if ($status == 'linked')
        $accountLinking->getAuthorizationCode();
});
```
- delivery
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Delivery;

$bionic->listen('delivery', function (Plugin $plugin, Sender $sender, Recipient $recipient, Delivery $delivery, $channel){
    $delivery->getMids();
    $delivery->getSeq();
    $delivery->getWatermark();
});
```
- read
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Read;

$bionic->listen('read', function (Plugin $plugin, Sender $sender, Recipient $recipient, Read $read, $channel){
    $read->getSeq();
    $read->getWatermark();
});
```
- policy_enforcement
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\PolicyEnforcement;

$bionic->listen('policy_enforcement', function (Plugin $plugin, Recipient $recipient, PolicyEnforcement $policyEnforcement){
    $action = $policyEnforcement->getAction();
    if ($action == 'block')
        $policyEnforcement->getReason();
});
```
- payment
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Payment\Payment;

$bionic->listen('payment', function (Plugin $plugin, Sender $sender, Recipient $recipient, Payment $payment){
    $payment->getShippingOptionId();
    $payment->getPaymentCredential();
    $payment->getRequestedUserInfo();
    $payment->getAmount();
});
```
- checkout_update
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Payment\CheckoutUpdate;

$bionic->listen('checkout_update', function (Plugin $plugin, Sender $sender, Recipient $recipient, CheckoutUpdate $checkoutUpdate){
    $checkoutUpdate->getPayload();
    $checkoutUpdate->getShippingAddress();
});
```
- pre_checkout
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Payment\PreCheckout;

$bionic->listen('pre_checkout', function (Plugin $plugin, Sender $sender, Recipient $recipient, PreCheckout $preCheckout){
    $preCheckout->getPayload();
    $preCheckout->getRequestedUserInfo();
    $preCheckout->getAmount();
});
```
- pass_thread_control
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\PassThreadControl;

$bionic->listen('pass_thread_control', function (Plugin $plugin, Sender $sender, Recipient $recipient, PassThreadControl $passThreadControl){
    $passThreadControl->getNewOwnerAppId();
    $passThreadControl->getMetadata();
});
```
- take_thread_control
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\TakeThreadControl;

$bionic->listen('take_thread_control', function (Plugin $plugin, Sender $sender, Recipient $recipient, TakeThreadControl $takeThreadControl){
    $takeThreadControl->getPreviousOwnerAppId();
    $takeThreadControl->getMetadata();
});
```
- app_roles
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\AppRoles;

$bionic->listen('app_roles', function (Plugin $plugin, Recipient $recipient, AppRoles $appRoles){
    $appRoles->getAppId();
    $appRoles->getAppRoles();
});
```
### Supported Buttons
**NOTE:** Explore class files for a better understanding of provided methods
- UrlButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\UrlButton;
$url_button = UrlButton::create();
```
- PostBackButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\PostBackButton;
$post_back_button = PostBackButton::create();
```
- ShareButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\ShareButton;
$share_button = ShareButton::create();
```
- CallButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\CallButton;
$call_button = CallButton::create();
```
- LoginButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\LoginButton;
$login_button = LoginButton::create();
```
- LogoutButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\LogoutButton;
$logout_button = LogoutButton::create();
```
- BuyButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\BuyButton;
$buy_button = BuyButton::create();
```
### Sending Messages
- Text and quick replies
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Nlp;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
    // sending text
    $plugin->sendText($text, [], $sender);
    
    // with quick reply
    $quick_replies = [
        QuickReply::create()->setContentType('text')->setTitle('Yes')->setPayload('yes'),
        QuickReply::create()->setContentType('text')->setTitle('No')->setPayload('no')
    ];
    $plugin->sendText($text, $quick_replies, $sender);
});
```
- Sender action
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Nlp;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
    $plugin->sendAction($sender); // default mark_seen
    $plugin->sendAction($sender, 'typing_on');
    $plugin->sendAction($sender, 'typing_off');
});
```
### Attachments
- Image
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Image $image, $channel){
    $plugin->sendAttachment($image, $sender);
});
```
- Audio
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Audio;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.audio', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Audio $audio, $channel){
    $plugin->sendAttachment($audio, $sender);
});
```
- Video
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Video;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.video', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Video $video, $channel){
    $plugin->sendAttachment($video, $sender);
});
```
### Supported Templates
- Generic Template
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\GenericTemplate;
use Andre\Bionic\Plugins\Messenger\Messages\Payload\GenericTemplatePayload;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\TemplateElement;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\UrlButton;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\PostBackButton;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Image $image, $channel){
    // actions
    $url_button = UrlButton::create(['url' => 'http://localhost']);
    $post_back_button = PostBackButton::create(['title' => 'Payload Button', 'payload' => 'payload_button']);
    
    // template element
    $template_element = TemplateElement::create()
        ->setImageUrl($image->getPayload()->getUrl())
        ->setTitle("Generic Template")
        ->setSubtitle("Am a generic template")
        ->setDefaultAction($url_button)
        ->setButtons([
            $url_button->setTitle("Url Button"),
            $post_back_button
        ]);
    
    // template payload
    $template_payload = GenericTemplatePayload::create()
        ->setElements([$template_element]);
    
    // generic template
    $generic_template = GenericTemplate::create()
        ->setPayload($template_payload);
    
    $plugin->sendAttachment($generic_template, $sender);
});
```
- List Template
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\ListTemplate;
use Andre\Bionic\Plugins\Messenger\Messages\Payload\ListTemplatePayload;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\TemplateElement;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\UrlButton;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\PostBackButton;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Image $image, $channel){
    // actions
    $url_button = UrlButton::create(['url' => 'http://localhost']);
    $post_back_button = PostBackButton::create(['title' => 'View', 'payload' => 'payload_button']);
    
    // template element
    $template_element = TemplateElement::create()
        ->setImageUrl($image->getPayload()->getUrl())
        ->setTitle("List Template")
        ->setSubtitle("Am a generic template")
        ->setDefaultAction($url_button)
        ->setButtons([$post_back_button]); // maximum of one button
    
    // template payload
    $template_payload = ListTemplatePayload::create()
        ->setElements([$template_element, $template_element, $template_element]);
    
    // list template
    $list_template = ListTemplate::create()
        ->setPayload($template_payload);
    
    $plugin->sendAttachment($list_template, $sender);
});
```
- Button Template
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\ButtonTemplate;
use Andre\Bionic\Plugins\Messenger\Messages\Payload\ButtonTemplatePayload;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\UrlButton;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\PostBackButton;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Nlp;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
    // actions
    $url_button = UrlButton::create(['url' => 'http://localhost', 'title' => 'Button']);
    $post_back_button = PostBackButton::create(['title' => 'PostBack', 'payload' => 'payload_button']);
    
    // template payload
    $template_payload = ButtonTemplatePayload::create()
        ->setText($text->getText())
        ->setButtons([$url_button, $post_back_button]);
    
    // button template
    $button_template = ButtonTemplate::create()
        ->setPayload($template_payload);
    
    $plugin->sendAttachment($button_template, $sender);
});
```
- Receipt Template
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Nlp;
use Andre\Bionic\Plugins\Messenger\Messages\Payment\ShippingAddress;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\Receipt\ReceiptSummary;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\TemplateElement;
use Andre\Bionic\Plugins\Messenger\Messages\Payload\ReceiptTemplatePayload;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\Receipt\ReceiptAdjustment;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\Receipt\ReceiptTemplate;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){

    $address = ShippingAddress::create()
        ->setStreet1('1 Hacker Way')
        ->setCity("Menlo Park")
        ->setPostalCode("94025")
        ->setState("CA")
        ->setCountry("US");

    $summary = ReceiptSummary::create()
        ->setSubtotal(75.00)
        ->setShippingCost(4.95)
        ->setTotalTax(6.19)
        ->setTotalCost(56.14);
    
    $element_1 = TemplateElement::create([
        "title" => "Classic White T-Shirt",
        "subtitle" => "100% Soft and Luxurious Cotton",
        "quantity" => 2,
        "price" => 50,
        "currency" => "USD",
        "image_url" => "http://petersapparel.parseapp.com/img/whiteshirt.png"
        ]);
    
    $element_2 = TemplateElement::create()
        ->setTitle("Classic Gray T-Shirt")
        ->setSubtitle("100% Soft and Luxurious Cotton")
        ->setQuantity(1)->setPrice(25)
        ->setCurrency("USD")
        ->setImageUrl("http://petersapparel.parseapp.com/img/grayshirt.png");
    
    $payload = ReceiptTemplatePayload::create()
        ->setRecipientName("Stephane Crozatier")
        ->setOrderNumber("12345678902")
        ->setCurrency("USD")
        ->setPaymentMethod("Visa 2345")
        ->setOrderUrl("http://petersapparel.parseapp.com/order?order_id=123456")
        ->setTimestamp("1428444852")
        ->setAddress($address)
        ->setSummary($summary)
        ->setElements([$element_1, $element_2])
        ->setAdjustments([
            ReceiptAdjustment::create(["name" => "New Customer Discount", "amount" => 20]),
            ReceiptAdjustment::create(["name" => "$10 Off Coupon", "amount" => 10])
        ]);
    
    $receipt = ReceiptTemplate::create()->setPayload($payload);
    
    $plugin->sendAttachment($receipt, $sender);
});
```
### Others
- Open Graph Template
- Media Template
### Accessing a user profile information
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Nlp;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
    $profile = $plugin->getUserProfile($sender); // returns an instance of Andre\Bionic\Plugins\Messenger\UserProfile::class
    $profile->getFirstName();
    $profile->getId();
    $profile->getLastName();
    $profile->getProfilePic();
    $plugin->sendPlainText('Hi, ' . $profile->getFirstName() . ' ' . $profile->getLastName(), [], $sender);
});
```
### Messenger Profile
- Setting the Get Started Button Postback
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\BotProfile\GetStarted;
$config = [
    'page_access_token' => 'your page access token'
];

$plugin = Plugin::create($config);
$plugin->setGetStarted(GetStarted::create(["payload" => "get_started"]));
```
- Setting the Greeting Text
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\BotProfile\GreetingText;
$config = [
    'page_access_token' => 'your page access token'
];

$plugin = Plugin::create($config);

$greeting_default = GreetingText::create(["locale" => "default", "text" => "Hello!"]);
$greeting_en_US = GreetingText::create(["locale" => "en_US", "text" => "Timeless apparel for the masses"]);

$plugin->setGreetingText([$greeting_default, $greeting_en_US]);
```
- Whitelisting domains
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
$config = [
    'page_access_token' => 'your page access token'
];

$plugin = Plugin::create($config);
$plugin->whitelistDomains(['http://example.com', 'http://app.example.com']);
```
- Persistent menu
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\BotProfile\PersistentMenu;
use Andre\Bionic\Plugins\Messenger\BotProfile\PersistentMenuItem;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\PostBackButton;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\UrlButton;
$config = [
    'page_access_token' => 'your page access token'
];

$plugin = Plugin::create($config);

$menu_item = PersistentMenuItem::create(["title" => "My Account", "type" => "nested"]);
$post_back_1 = PostBackButton::create(["title" => "Pay Bill", "payload" => "PAYBILL_PAYLOAD"]);
$post_back_2 = PostBackButton::create(["title" => "History", "payload" => "HISTORY_PAYLOAD"]);
$post_back_3 = PostBackButton::create(["title" => "Contact Info", "payload" => "CONTACT_INFO_PAYLOAD"]);

$menu_item->setCallToActions([$post_back_1, $post_back_2, $post_back_3]);
$url_button = UrlButton::create(["title" => "Contact Info", "url" => "http://example.com"]);

$persistent_menu_default = PersistentMenu::create(['locale' => 'default', 'composer_input_disabled' => false]);
$persistent_menu_default->setCallToActions([$menu_item, $url_button]);

$persistent_menu_zh_CN = PersistentMenu::create(['locale' => 'zh_CN', 'composer_input_disabled' => false]);
$persistent_menu_zh_CN->setCallToActions([$post_back_1]);

$plugin->setPersistentMenu([$persistent_menu_default, $persistent_menu_zh_CN]);
```
- Deleting Messenger Profile Properties
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;

$config = [
    'page_access_token' => 'your page access token'
];

$plugin = Plugin::create($config);
$plugin->deleteProperties(['persistent_menu', 'get_started', 'greeting', 'whitelisted_domains']);

```
- Setting public key for Tokenized Payments
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;

$config = [
    'page_access_token' => 'your page access token'
];

$plugin = Plugin::create($config);
$plugin->setPublicKey("<YOUR_PUBLIC_KEY>");

```
- Setting Payment Privacy Policy URL
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;

$config = [
    'page_access_token' => 'your page access token'
];

$plugin = Plugin::create($config);
$plugin->setPrivacyUrl("<YOUR_PRIVACY_URL>");

```
### Handover Protocol
- Passing Thread Control
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Nlp;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
    $plugin->passThreadControl($sender, '123456789', 'String to pass to secondary receiver app');
});

```
- Taking Thread Control
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Nlp;
use Andre\Bionic\Plugins\Messenger\Messages\Message;

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
    $plugin->takeThreadControl($sender, 'String to pass to secondary receiver app');
});

```

## Usage with Telegram

```php
<?php
use Andre\Bionic\Bionic;
use Andre\Bionic\Plugins\Telegram\TelegramPlugin as Plugin;
use Andre\Bionic\Plugins\Telegram\Message as TelegramMessage;

$data = json_decode(file_get_contents('php://input'), true);

$config = [
    'access_token' => 'your telegram access token',
];


$bionic = Bionic::initialize()
    ->setPlugin(Plugin::create($config));

// register your event listeners before calling the 'receive' method on the bionic instance
// $bionic->listen($event_name, $event_listener);
$bionic->listen('message', function (Plugin $plugin, $update_id, TelegramMessage $message) {
            
})->listen('channel-message', function (Plugin $plugin, $update_id, TelegramMessage $message) {
            
})->listen('edited-message', function (Plugin $plugin, $update_id, TelegramMessage $message) {
            
})->listen('edited-channel-message', function (Plugin $plugin, $update_id, TelegramMessage $message) {
            
});

$bionic->receive($data);
return http_response_code(200);
```

## Usage with Viber

```php
<?php
use Andre\Bionic\Bionic;
use Andre\Bionic\Plugins\Viber\ViberPlugin as Plugin;
use Andre\Bionic\Plugins\Viber\Message as ViberMessage;
use Andre\Bionic\Plugins\Viber\User as ViberUser;

$data = json_decode(file_get_contents('php://input'), true);

$config = [
    'access_token' => 'your viber access token',
];


$bionic = Bionic::initialize()
    ->setPlugin(Plugin::create($config));

// register your event listeners before calling the 'receive' method on the bionic instance
// $bionic->listen($event_name, $event_listener);
$bionic->listen('webhook', function (Plugin $plugin, $timestamp, $message_token) {
    
})->listen('subscribed', function (Plugin $plugin, $timestamp, $message_token, ViberUser $user) {
    
})->listen('un-subscribed', function (Plugin $plugin, $timestamp, $message_token, $user_id) {
    
})->listen('conversation-started', function (Plugin $plugin, $timestamp, $message_token, $type, $context, ViberUser $user, $subscribed) {
    
})->listen('delivered', function (Plugin $plugin, $timestamp, $message_token, $user_id) {
    
})->listen('seen', function (Plugin $plugin, $timestamp, $message_token, $user_id) {
    
})->listen('failed', function (Plugin $plugin, $timestamp, $message_token, $user_id, $desc) {
   
})->listen('message', function (Plugin $plugin, $timestamp, $message_token, ViberUser $user, ViberMessage $message) {
    
});

$bionic->receive($data);
return http_response_code(200);
```

## Exception handling
Any exceptions not caught when you are defining your event listeners logic are automatically captured. So remember to register a listener that listens for these exceptions.
```php
<?php

$bionic->listen('exception', function (\Exception $exception){
    $exception->getMessage();
});

```

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md). In short: `composer test`, `composer analyse` and `composer lint` must pass.

## Changelog

See [CHANGELOG.md](CHANGELOG.md).

## Bugs
For any bugs found, please email me at andrewmvp007@gmail.com or register an issue at [issues](https://github.com/mpaannddreew/bionic-php/issues)
