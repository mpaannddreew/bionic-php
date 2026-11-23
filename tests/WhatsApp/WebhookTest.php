<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Tests\WhatsApp;

use Andre\Bionic\Plugins\WhatsApp\Contacts\Contact;
use Andre\Bionic\Plugins\WhatsApp\Error;
use Andre\Bionic\Plugins\WhatsApp\Message;
use Andre\Bionic\Plugins\WhatsApp\Messages\Audio;
use Andre\Bionic\Plugins\WhatsApp\Messages\Button;
use Andre\Bionic\Plugins\WhatsApp\Messages\Document;
use Andre\Bionic\Plugins\WhatsApp\Messages\Image;
use Andre\Bionic\Plugins\WhatsApp\Messages\Interactive;
use Andre\Bionic\Plugins\WhatsApp\Messages\Location;
use Andre\Bionic\Plugins\WhatsApp\Messages\Sticker;
use Andre\Bionic\Plugins\WhatsApp\Messages\Text;
use Andre\Bionic\Plugins\WhatsApp\Messages\Video;
use Andre\Bionic\Plugins\WhatsApp\MetaData;
use Andre\Bionic\Plugins\WhatsApp\Status;
use Andre\Bionic\Plugins\WhatsApp\WhatsAppPlugin;
use Andre\Bionic\Tests\RecordingBionic;
use Andre\Bionic\Tests\TestCase;

/**
 * Payloads in tests/fixtures/whatsapp are Meta's documented webhook examples
 * (WhatsApp Cloud API > Webhooks > Reference > messages).
 */
class WebhookTest extends TestCase
{
    private function receiveFixture(string $name): RecordingBionic
    {
        return $this->receive(WhatsAppPlugin::create(), $this->fixture("whatsapp/$name.json"));
    }

    public function testTextMessage(): void
    {
        $bionic = $this->receiveFixture('text');

        $this->assertSame([
            'entry',
            'entry.item',
            'changes',
            'change',
            'change.value',
            'messages',
            'message',
            'message.text',
        ], $bionic->eventNames());

        [$plugin, $meta, $contacts, $message, $text] = $bionic->argumentsOf('message.text');

        $this->assertInstanceOf(WhatsAppPlugin::class, $plugin);

        $this->assertInstanceOf(MetaData::class, $meta);
        $this->assertSame('15550783881', $meta->getDisplayPhoneNumber());
        $this->assertSame('106540352242922', $meta->getPhoneNumberId());

        $this->assertCount(1, $contacts);
        $this->assertInstanceOf(Contact::class, $contacts[0]);
        $this->assertSame('16505551234', $contacts[0]->getWaId());
        $this->assertSame('US.13491208655302741918', $contacts[0]->getUserId());
        $this->assertSame('Sheena Nelson', $contacts[0]->getProfile()->getName());

        $this->assertInstanceOf(Message::class, $message);
        $this->assertSame('wamid.HBgLMTY1MDM4Nzk0MzkVAgASGBQzQTRBNjU5OUFFRTAzODEwMTQ0RgA=', $message->getId());
        $this->assertSame('16505551234', $message->getFrom());
        $this->assertSame('US.13491208655302741918', $message->getFromUserId());
        $this->assertSame('1749416383', $message->getTimestamp());
        $this->assertSame('text', $message->getType());

        $this->assertInstanceOf(Text::class, $text);
        $this->assertSame('Does it come in another color?', $text->getBody());
    }

    public function testImageMessage(): void
    {
        $bionic = $this->receiveFixture('image');

        $this->assertContains('message.image', $bionic->eventNames());
        $this->assertNotContains('message.text', $bionic->eventNames());

        $image = $bionic->argumentsOf('message.image')[4];

        $this->assertInstanceOf(Image::class, $image);
        $this->assertSame('1003383421387256', $image->getId());
        $this->assertSame('Taj Mahal', $image->getCaption());
        $this->assertSame('image/jpeg', $image->getMimeType());
        $this->assertSame('SfInY0gGKTsJlUWbwxC1k+FAD0FZHvzwfpvO0zX0GUI=', $image->getSha256());
        $this->assertSame('https://lookaside.fbsbx.com/whatsapp_business/attachments/?mid=133...', $image->getUrl());
    }

    public function testOtherMediaMessages(): void
    {
        $video = $this->receiveFixture('video')->argumentsOf('message.video')[4];
        $this->assertInstanceOf(Video::class, $video);
        $this->assertSame('731675419373506', $video->getId());
        $this->assertSame('Timelapse of growth', $video->getCaption());

        // Audio is emitted as message.voice, as it always has been.
        $audio = $this->receiveFixture('audio')->argumentsOf('message.voice')[4];
        $this->assertInstanceOf(Audio::class, $audio);
        $this->assertSame('1908647269898587', $audio->getId());
        $this->assertSame('audio/ogg; codecs=opus', $audio->getMimeType());
        $this->assertTrue($audio->isVoice());

        $document = $this->receiveFixture('document')->argumentsOf('message.document')[4];
        $this->assertInstanceOf(Document::class, $document);
        $this->assertSame('receipt.pdf', $document->getFilename());
        $this->assertSame('application/pdf', $document->getMimeType());

        $sticker = $this->receiveFixture('sticker')->argumentsOf('message.sticker')[4];
        $this->assertInstanceOf(Sticker::class, $sticker);
        $this->assertSame('image/webp', $sticker->getMimeType());
        $this->assertTrue($sticker->isAnimated());
        $this->assertSame('https://lookaside.fbsbx.com/whatsapp_business/attachments/?mid=133...', $sticker->getUrl());
    }

    public function testLocationMessage(): void
    {
        $location = $this->receiveFixture('location')->argumentsOf('message.location')[4];

        $this->assertInstanceOf(Location::class, $location);
        $this->assertSame(37.44221496582, $location->getLatitude());
        $this->assertSame(-122.16165924072, $location->getLongitude());
        $this->assertSame('Philz Coffee', $location->getName());
        $this->assertSame('101 Forest Ave, Palo Alto, CA 94301', $location->getAddress());
        $this->assertSame('https://philzcoffee.com/', $location->getUrl());
    }

    public function testContactsMessage(): void
    {
        $sent = $this->receiveFixture('contacts')->argumentsOf('message.contacts')[4];

        $this->assertCount(1, $sent);
        $this->assertSame('Barbara J. Johnson', $sent[0]['name']['formatted_name']);
        $this->assertSame('14125550829', $sent[0]['phones'][0]['wa_id']);
    }

    public function testInteractiveButtonReply(): void
    {
        $bionic = $this->receiveFixture('interactive_button_reply');

        [, , , $message, $interactive] = $bionic->argumentsOf('message.interactive');

        $this->assertSame('wamid.HBgLMTY1MDM4Nzk0MzkVAgARGBI3MEM2RUJFNkI0RENGQTVDRjUA', $message->getContext()->getId());
        $this->assertInstanceOf(Interactive::class, $interactive);
        $this->assertSame('button_reply', $interactive->getType());
        $this->assertSame(['id' => 'cancel-button', 'title' => 'Cancel'], $interactive->getButtonReply());
        $this->assertSame('cancel-button', $interactive->getReplyId());
        $this->assertSame('Cancel', $interactive->getReplyTitle());
    }

    public function testInteractiveListReply(): void
    {
        $interactive = $this->receiveFixture('interactive_list_reply')->argumentsOf('message.interactive')[4];

        $this->assertSame('list_reply', $interactive->getType());
        $this->assertSame('priority_express', $interactive->getReplyId());
        $this->assertSame('Priority Mail Express', $interactive->getReplyTitle());
        $this->assertSame('Next Day to 2 Days', $interactive->getListReply()['description']);
    }

    public function testTemplateQuickReplyButton(): void
    {
        $button = $this->receiveFixture('button')->argumentsOf('message.button')[4];

        $this->assertInstanceOf(Button::class, $button);
        $this->assertSame('Unsubscribe', $button->getPayload());
        $this->assertSame('Unsubscribe', $button->getText());
    }

    public function testSentStatus(): void
    {
        $bionic = $this->receiveFixture('status_sent');

        $this->assertSame([
            'entry',
            'entry.item',
            'changes',
            'change',
            'change.value',
            'statuses',
            'status',
            'status.sent',
        ], $bionic->eventNames());

        [, $meta, $status] = $bionic->argumentsOf('status.sent');

        $this->assertSame('106540352242922', $meta->getPhoneNumberId());
        $this->assertInstanceOf(Status::class, $status);
        $this->assertSame('wamid.HBgLMTY1MDM4Nzk0MzkVAgASGBQzQUFERjg0NDEzNDdFODU3MUMxMAA=', $status->getId());
        $this->assertSame('sent', $status->getStatus());
        $this->assertSame('1750030073', $status->getTimestamp());
        $this->assertSame('16505551234', $status->getRecipientId());
        $this->assertSame('US.13491208655302741918', $status->getRecipientUserId());
        $this->assertSame('marketing', $status->getConversation()['origin']['type']);
        $this->assertSame('PMP', $status->getPricing()['pricing_model']);
        $this->assertTrue($status->getPricing()['billable']);
        $this->assertSame([], $status->getErrors());
    }

    public function testDeliveredStatusWithoutPhoneNumber(): void
    {
        $status = $this->receiveFixture('status_delivered')->argumentsOf('status.delivered')[2];

        $this->assertSame('delivered', $status->getStatus());
        $this->assertNull($status->getRecipientId());
        $this->assertSame('US.13491208655302741918', $status->getRecipientUserId());
    }

    public function testFailedStatus(): void
    {
        $bionic = $this->receiveFixture('status_failed');

        $this->assertContains('status.failed', $bionic->eventNames());

        $status = $bionic->argumentsOf('status.failed')[2];
        $errors = $status->getErrors();

        $this->assertCount(1, $errors);
        $this->assertInstanceOf(Error::class, $errors[0]);
        $this->assertSame(131049, $errors[0]->getCode());
        $this->assertSame('This message was not delivered to maintain healthy ecosystem engagement.', $errors[0]->getTitle());
        $this->assertSame('In order to maintain a healthy ecosystem engagement, the message failed to be delivered.', $errors[0]->getDetails());
        $this->assertSame('/documentation/business-messaging/whatsapp/support/error-codes', $errors[0]->getHref());
    }

    public function testErrors(): void
    {
        $bionic = $this->receiveFixture('errors');

        $this->assertSame([
            'entry',
            'entry.item',
            'changes',
            'change',
            'change.value',
            'errors',
            'error',
        ], $bionic->eventNames());

        [, $meta, $errors] = $bionic->argumentsOf('errors');
        $this->assertSame('106540352242922', $meta->getPhoneNumberId());
        $this->assertCount(1, $errors);

        $error = $bionic->argumentsOf('error')[2];
        $this->assertInstanceOf(Error::class, $error);
        $this->assertSame(130429, $error->getCode());
        $this->assertSame('Rate limit hit', $error->getTitle());
        $this->assertSame('Rate limit hit', $error->getMessage());
        $this->assertSame(
            'Message failed to send because there were too many messages sent from this phone number in a short period of time',
            $error->getDetails()
        );
        $this->assertSame($error->getDetails(), $error->getErrorData()['details']);
    }

    public function testListenersRegisteredWithListenReceiveEvents(): void
    {
        $received = null;

        $bionic = RecordingBionic::initialize();
        $bionic->setPlugin(WhatsAppPlugin::create());
        $bionic->listen('message.text', function ($plugin, $meta, $contacts, $message, $text) use (&$received) {
            $received = $text->getBody();
        });
        $bionic->receive($this->fixture('whatsapp/text.json'));

        $this->assertSame('Does it come in another color?', $received);
    }
}
