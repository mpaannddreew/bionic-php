## Bionic

Bionic is a simple chat bot development library in PHP.

It is driven by a very simple but powerful event dispatching library [Événement](https://github.com/igorw/evenement)

- Currently has support for only messenger chat bot development.

## Installation

The recommended way to install Bionic is [through composer](http://getcomposer.org).

Just create a composer.json file for your project and require it:

```TERMINAL
composer require andre/bionic
```
Now you can add the autoloader, and you will have access to the library:

```php
<?php
require 'vendor/autoload.php';
```

## Usage
**Note:** This library does not help you setup a webhook, so you must have a functioning webhook registered to receive messenger webhook events.
### Creating a Bionic instance

```php
<?php
use Andre\Bionic\Bionic;

$bionic = new Bionic();
```

### Usage with a messenger plugin instance

```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin;

$config = [
    'page_access_token' => ''
];
$plugin = new MessengerPlugin($config);
$bionic->setPlugin($plugin);
// register your event listeners before calling the 'receive' method on the bionic instance
// $bionic->listen($event_name, $event_listener);
$bionic->receive($incoming_webhook_data);
return response($status = 200);
```
### Registering an event listener
### Syntax

```php
<?php
$bionic->listen($event_name, $event_listener);
```
### With an anonymous function

```php
<?php
$bionic->listen($event_name, function($required_parameters_depending_on_event_name){});
```
### With a defined function

```php
<?php
function function_name($required_parameters_depending_on_event_name){}

$bionic->listen($event_name, 'function_name');
```
### With a class method

```php
<?php
class BotController{
    public function function_name($required_parameters_depending_on_event_name){}
}

$controller = new BotController();
$bionic->listen($event_name, [$controller, 'function_name']);
```

### With a static class method

```php
<?php
class BotController{
    public static function function_name($required_parameters_depending_on_event_name){}
}

$bionic->listen($event_name, [BotController::class, 'function_name']);
```
### Basic example

```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Image $image){
    // $plugin - current plugin being used i.e. MessengerPlugin
    // $sender - sender of the message i.e. Messenger user
    // $recipient - recipient of the message i.e. Your facebook page
    // $image - Image attachment that was sent
   
    // this sends back the attachment as a message back to the sender
    $plugin->sendAttachment($image, $sender);
});
```

### Available events provided for messenger

- entry
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;

$bionic->listen('entry', function (Plugin $plugin, $entryItems){
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
    }
});
```
- messaging
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;

$bionic->listen('messaging', function (Plugin $plugin, $messagingItems){
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
     }
});
```
- messaging.item
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\MessagingItem;

$bionic->listen('messaging.item', function (Plugin $plugin, MessagingItem $messagingItem){
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
});
```
- message
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message;


$bionic->listen('message', function (Plugin $plugin, Sender $sender, Recipient $recipient, Message $message){
    $message->getText();
    $message->getQuickReply();
    $message->getAppId();
    $message->getAttachmentItems();
    $message->getMetadata();
    $message->getMid();
    $message->getSeq();
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
    // $message - represents messages sent by your page
    $message->getText();
    $message->getQuickReply();
    $message->getAppId();
    $message->getAttachmentItems();
    $message->getMetadata();
    $message->getMid();
    $message->getSeq();
});
```
- message.text
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;


$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null){
    $text->getText();
    if ($quickReply){
        $quickReply->getPayload();
    }
});
```
- message.attachments
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;


$bionic->listen('message.attachments', function (Plugin $plugin, Sender $sender, Recipient $recipient, $messageAttachments){
    // $messageAttachments - an array of attachments e.g. Image, Audio, Location, Video, Fallback
    foreach ($messageAttachments as $attachment){
        $attachment->getType();
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

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Image $image){
    $image->getPayload()->getUrl();
});
```
- message.attachments.audio
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Audio;

$bionic->listen('message.attachments.audio', function (Plugin $plugin, Sender $sender, Recipient $recipient, Audio $audio){
    $audio->getPayload()->getUrl();
});
```
- message.attachments.video
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Video;

$bionic->listen('message.attachments.video', function (Plugin $plugin, Sender $sender, Recipient $recipient, Video $video){
    $video->getPayload()->getUrl();
});
```
- message.attachments.location
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Location;

$bionic->listen('message.attachments.video', function (Plugin $plugin, Sender $sender, Recipient $recipient, Location $location){
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

$bionic->listen('message.attachments.file', function (Plugin $plugin, Sender $sender, Recipient $recipient, File $file){
    $file->getPayload()->getUrl();
});
```
- message.attachments.fallback
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Fallback;

$bionic->listen('message.attachments.fallback', function (Plugin $plugin, Sender $sender, Recipient $recipient, Fallback $fallback){
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

$bionic->listen('optin', function (Plugin $plugin, Sender $sender, Recipient $recipient, Optin $optin){
    $optin->getRef();
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

$bionic->listen('delivery', function (Plugin $plugin, Sender $sender, Recipient $recipient, Delivery $delivery){
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

$bionic->listen('read', function (Plugin $plugin, Sender $sender, Recipient $recipient, Read $read){
    $read->getSeq();
    $read->getWatermark();
});
```
