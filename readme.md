## Bionic

Bionic is a simple chat bot development library in PHP.

It is driven by a very simple but powerful event dispatching library [Événement](https://github.com/igorw/evenement) and [Guzzle](https://github.com/guzzle/guzzle) a PHP HTTP client that makes it easy to send HTTP requests

## Platform support

* Facebook Messenger
* more coming


## Facebook Messenger

## What is covered

* Create a FB Page
* Create a FB Messenger app
* Create a webhook
* Connect the Facebook app to the Facebook page
* Setup Bionic

## Installation
### Create a FB page

First login to Facebook and [create a Facebook page](https://www.facebook.com/pages/create). Choose the settings that 
fits best your bot, but for testing it is not important.

### Create a FB Messenger app

Go to the [developer's app page](https://developers.facebook.com/apps/). Click "Add a New App" and
 fill the basic app fields.

On the "Product Setup" page choose Messenger and click "Get Started".

Now you need to create a token to give your app access to your Facebook page. Select the created page, grant permissions 
and copy the generated token. You need that one later.

### Create a webhook for the messenger app

Your application needs to have a webhook. This means a public URL that Facebook can communicate with. Every time a user 
sends a message inside the FB chat, FB will send it to this URL which is the entry point to your application.

### Connect the Facebook app to your application

Now that you got the URL you need to setup the webhook. Go back to you Facebook app settings and click `Setup Webhooks` 
inside the Webhooks part.

Fill in the public URL, check the subscription fields you want to with and click `Verify and Save`.

***Note:*** You need to write your own webhook verification logic in your application.

### Setup Bionic

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
### Creating a Bionic instance

```php
<?php
use Andre\Bionic\Bionic;

$bionic = Bionic::initialize();
```

### Usage with messenger

```php
<?php
use Andre\Bionic\Bionic;
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;

$config = [
    'page_access_token' => 'your page access token',
    // 'graph_api_version' => 'v2.10' optional and defaults to v2.10
];

$bionic = Bionic::initialize()
    ->setPlugin(Plugin::create($config));

// register your event listeners before calling the 'receive' method on the bionic instance
// $bionic->listen($event_name, $event_listener);
$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Image $image, $channel){
    // $plugin - current plugin being used i.e. MessengerPlugin
    // $sender - sender of the message i.e. Messenger user
    // $recipient - recipient of the message i.e. Your facebook page
    // $image - Image attachment that was sent
    // $channel - event delivery channel, messaging or standby
   
    // this sends the attachment as a message back to the sender
    $plugin->sendAttachment($image, $sender);
});

$bionic->receive($incoming_web_hook_data_array);
return http_response_code(200);
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
### Basic example

```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Image $image, $channel){  
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
use Andre\Bionic\Plugins\Messenger\Messages\Message\Nlp;

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
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

$bionic->listen('message.attachments', function (Plugin $plugin, Sender $sender, Recipient $recipient, $messageAttachments, $channel){
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

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Image $image, $channel){
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

$bionic->listen('message.attachments.audio', function (Plugin $plugin, Sender $sender, Recipient $recipient, Audio $audio, $channel){
    $audio->getPayload()->getUrl();
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

$bionic->listen('message.attachments.video', function (Plugin $plugin, Sender $sender, Recipient $recipient, Video $video, $channel){
    $video->getPayload()->getUrl();
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

$bionic->listen('message.attachments.location', function (Plugin $plugin, Sender $sender, Recipient $recipient, Location $location, $channel){
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

$bionic->listen('message.attachments.file', function (Plugin $plugin, Sender $sender, Recipient $recipient, File $file, $channel){
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

$bionic->listen('message.attachments.fallback', function (Plugin $plugin, Sender $sender, Recipient $recipient, Fallback $fallback, $channel){
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
## Supported Buttons
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

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
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

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
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

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Image $image, $channel){
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

$bionic->listen('message.attachments.audio', function (Plugin $plugin, Sender $sender, Recipient $recipient, Audio $audio, $channel){
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

$bionic->listen('message.attachments.video', function (Plugin $plugin, Sender $sender, Recipient $recipient, Video $video, $channel){
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

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Image $image, $channel){
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

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Image $image, $channel){
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

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
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

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){

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

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
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

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
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

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null, Nlp $nlp = null, $channel){
    $plugin->takeThreadControl($sender, 'String to pass to secondary receiver app');
});

```
### Bugs
For any bugs found, please email me at andrewmvp007@gmail.com or register an issue at [issues](https://github.com/mpaannddreew/bionic-php/issues)

