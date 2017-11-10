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
use Andre\Bionic\Plugins\Messenger\MessengerPlugin;

$config = [
    'page_access_token' => ''
];

$bionic = Bionic::initialize();

// register your event listeners before calling the 'receive' method on the bionic instance
// $bionic->listen($event_name, $event_listener);

$bionic->setPlugin(MessengerPlugin::create($config))->receive($incoming_web_hook_data_array);
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
    // $message - represents message sent to your page
    $message->getText();
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
use Andre\Bionic\Plugins\Messenger\Messages\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;


$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null){
    $text->getText();
    if ($quickReply){
        $quickReply->getPayload();
    }
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


$bionic->listen('message.attachments', function (Plugin $plugin, Sender $sender, Recipient $recipient, $messageAttachments){
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

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Image $image){
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

$bionic->listen('message.attachments.audio', function (Plugin $plugin, Sender $sender, Recipient $recipient, Audio $audio){
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

$bionic->listen('message.attachments.video', function (Plugin $plugin, Sender $sender, Recipient $recipient, Video $video){
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

$bionic->listen('message.attachments.location', function (Plugin $plugin, Sender $sender, Recipient $recipient, Location $location){
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
## Working with Buttons
### UrlButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\UrlButton;
$url_button = UrlButton::create();
```
### PostBackButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\PostBackButton;
$post_back_button = PostBackButton::create();
```
### ShareButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\ShareButton;
$share_button = ShareButton::create();
```
### CallButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\CallButton;
$call_button = CallButton::create();
```
### LoginButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\LoginButton;
$login_button = LoginButton::create();
```
### LogoutButton
```php
<?php
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\LogoutButton;
$logout_button = LogoutButton::create();
```
## Sending Messages
### Text and quick replies
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;


$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null){
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
### Sender action
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;


$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null){
    $plugin->sendAction($sender); // default mark_seen
    $plugin->sendAction($sender, 'typing_on');
    $plugin->sendAction($sender, 'typing_off');
});
```
### Templates
#### Generic Template
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

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Image $image){
    // actions
    $url_button = UrlButton::create(['url' => 'http://localhost']);
    $post_back_button = PostBackButton::create(['title' => 'Payload Button', 'payload' => 'payload_button']);
    
    // template element
    $template_element = TemplateElement::create();
    $template_element->setImageUrl($image->getPayload()->getUrl());
    $template_element->setTitle("Generic Template");
    $template_element->setSubtitle("Am a generic template");
    $template_element->setDefaultAction($url_button->toArray());
    $template_element->setButtons([
        $url_button->setTitle("Url Button")->toArray(),
        $post_back_button->toArray()
    ]);
    
    // template payload
    $template_payload = GenericTemplatePayload::create();
    $template_payload->setElements([$template_element->toArray()]);
    
    // generic template
    $generic_template = GenericTemplate::create();
    $generic_template->setPayload($template_payload->toArray());
    
    $plugin->sendAttachment($generic_template, $sender);
});
```
#### List Template
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

$bionic->listen('message.attachments.image', function (Plugin $plugin, Sender $sender, Recipient $recipient, Image $image){
    // actions
    $url_button = UrlButton::create(['url' => 'http://localhost']);
    $post_back_button = PostBackButton::create(['title' => 'View', 'payload' => 'payload_button']);
    
    // template element
    $template_element = TemplateElement::create();
    $template_element->setImageUrl($image->getPayload()->getUrl());
    $template_element->setTitle("List Template");
    $template_element->setSubtitle("Am a generic template");
    $template_element->setDefaultAction($url_button->toArray());
    $template_element->setButtons([$post_back_button->toArray()]); // maximum of one button
    
    // template payload
    $template_payload = ListTemplatePayload::create();
    $template_payload->setElements([$template_element->toArray(), $template_element->toArray(), $template_element->toArray()]);
    
    // list template
    $list_template = ListTemplate::create();
    $list_template->setPayload($template_payload->toArray());
    
    $plugin->sendAttachment($list_template, $sender);
});
```
#### Button Template
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\ButtonTemplate;
use Andre\Bionic\Plugins\Messenger\Messages\Payload\ButtonTemplatePayload;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\UrlButton;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\PostBackButton;
use Andre\Bionic\Plugins\Messenger\Messages\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null){
    // actions
    $url_button = UrlButton::create(['url' => 'http://localhost', 'title' => 'Button']);
    $post_back_button = PostBackButton::create(['title' => 'PostBack', 'payload' => 'payload_button']);
    
    // template payload
    $template_payload = ButtonTemplatePayload::create();
    $template_payload->setText($text->getText());
    $template_payload->setButtons([$url_button->toArray(), $post_back_button->toArray()]);
    
    // button template
    $button_template = ButtonTemplate::create();
    $button_template->setPayload($template_payload->toArray());
    
    $plugin->sendAttachment($button_template, $sender);
});
```
### Accessing a user profile information
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\Text;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;

$bionic->listen('message.text', function (Plugin $plugin, Sender $sender, Recipient $recipient, Text $text, QuickReply $quickReply = null){
    $profile = $plugin->getUserProfile($sender); // returns an instance of Andre\Bionic\Plugins\Messenger\UserProfile::class
    $profile->getFirstName();
    $profile->getId();
    $profile->getLastName();
    $profile->getProfilePic();
    $plugin->sendPlainText('Hi, ' . $profile->getFirstName() . ' ' . $profile->getLastName(), [], $sender);
});
```
## Messenger Profile
### Setting the Get Started Button Postback
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\BotProfile\GetStarted;
$config = [
    'page_access_token' => ''
];

$plugin = Plugin::create($config);
$plugin->setGetStarted(GetStarted::create(["payload" => "get_started"]));
```
### Setting the Greeting Text
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\BotProfile\GreetingText;
$config = [
    'page_access_token' => ''
];

$plugin = Plugin::create($config);

$greeting_default = GreetingText::create(["locale" => "default", "text" => "Hello!"]);
$greeting_en_US = GreetingText::create(["locale" => "en_US", "text" => "Timeless apparel for the masses"]);

$plugin->setGreetingText([$greeting_default, $greeting_en_US]);
```
### Whitelisting domains
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
$config = [
    'page_access_token' => ''
];

$plugin = Plugin::create($config);
$plugin->whitelistDomains(['http://example.com', 'http://app.example.com']);
```
### Persistent menu
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;
use Andre\Bionic\Plugins\Messenger\BotProfile\PersistentMenu;
use Andre\Bionic\Plugins\Messenger\BotProfile\PersistentMenuItem;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\PostBackButton;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\UrlButton;
$config = [
    'page_access_token' => ''
];

$plugin = Plugin::create($config);

$menu_item = PersistentMenuItem::create(["title" => "My Account", "type" => "nested"]);
$post_back_1 = PostBackButton::create(["title" => "Pay Bill", "payload" => "PAYBILL_PAYLOAD"]);
$post_back_2 = PostBackButton::create(["title" => "History", "payload" => "HISTORY_PAYLOAD"]);
$post_back_3 = PostBackButton::create(["title" => "Contact Info", "payload" => "CONTACT_INFO_PAYLOAD"]);

$menu_item->setCallToActions([$post_back_1->toArray(), $post_back_2->toArray(), $post_back_3->toArray()]);
$url_button = UrlButton::create(["title" => "Contact Info", "url" => "http://example.com"]);

$persistent_menu_default = PersistentMenu::create(['locale' => 'default', 'composer_input_disabled' => false]);
$persistent_menu_default->setCallToActions([$menu_item->toArray(), $url_button->toArray()]);

$persistent_menu_zh_CN = PersistentMenu::create(['locale' => 'zh_CN', 'composer_input_disabled' => false]);
$persistent_menu_zh_CN->setCallToActions([$post_back_1->toArray()]);

$plugin->setPersistentMenu([$persistent_menu_default, $persistent_menu_zh_CN]);
```
### Deleting Messenger Profile Properties
```php
<?php
use Andre\Bionic\Plugins\Messenger\MessengerPlugin as Plugin;

$config = [
    'page_access_token' => ''
];

$plugin = Plugin::create($config);
$plugin->deleteProperties(['persistent_menu', 'get_started', 'greeting', 'whitelisted_domains']);

```
## Bugs
For any bugs found, please email me at andrewmvp007@gmail.com or register an issue at [issues](https://github.com/mpaannddreew/bionic-php/issues)

